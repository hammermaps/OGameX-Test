<?php

namespace Tests\Feature;

use OGame\Models\AiGlobalSettings;
use OGame\Models\AiPlayer;
use OGame\Models\AiPlayerLog;
use OGame\Models\User;
use Tests\AccountTestCase;

/**
 * Verify the AI player admin endpoints (global settings page and JSON feeds for
 * the auto-update widgets) behave correctly for both regular users and admins.
 */
class AiPlayerAdminTest extends AccountTestCase
{
    private const ADMIN_JSON_PATHS = [
        '/admin/ai-players/daemon/status.json',
        '/admin/ai-players/activity-log.json',
    ];

    private const ADMIN_HTML_PATHS = [
        '/admin/ai-players',
        '/admin/ai-players/settings',
        '/admin/ai-players/daemon',
        '/admin/ai-players/activity-log',
    ];

    /**
     * A normal user must not be able to reach any of the AI admin endpoints.
     */
    public function testNormalUserAccessDenied(): void
    {
        $this->artisan('ogamex:admin:remove-role', ['username' => auth()->user()->username]);

        foreach (array_merge(self::ADMIN_HTML_PATHS, self::ADMIN_JSON_PATHS) as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/overview');
        }
    }

    /**
     * The settings page renders for admin users and shows the configured fields.
     */
    public function testAdminCanRenderSettingsPage(): void
    {
        $this->artisan('ogamex:admin:assign-role', ['username' => auth()->user()->username]);

        $response = $this->get('/admin/ai-players/settings');
        $response->assertStatus(200);
        $response->assertSee('AI Global Settings', false);
        $response->assertSee('max_concurrent_players', false);
        $response->assertSee('log_retention_days', false);
        $response->assertSee('autoupdate_daemon_interval_seconds', false);
    }

    /**
     * The settings form persists the values back into the database.
     */
    public function testAdminCanUpdateSettings(): void
    {
        $this->artisan('ogamex:admin:assign-role', ['username' => auth()->user()->username]);

        $response = $this->put('/admin/ai-players/settings', [
            'daemon_enabled' => '1',
            'max_concurrent_players' => 25,
            'default_action_interval_min' => 30,
            'default_action_interval_max' => 120,
            'default_sleep_start' => '02:00',
            'default_sleep_end' => '06:00',
            'log_retention_days' => 14,
            'autoupdate_daemon_interval_seconds' => 7,
            'autoupdate_logs_interval_seconds' => 15,
        ]);

        $response->assertRedirect('/admin/ai-players/settings');

        $settings = AiGlobalSettings::singleton()->refresh();
        $this->assertTrue($settings->daemon_enabled);
        $this->assertSame(25, $settings->max_concurrent_players);
        $this->assertSame(14, $settings->log_retention_days);
        $this->assertSame(7, $settings->autoupdate_daemon_interval_seconds);
        $this->assertSame(15, $settings->autoupdate_logs_interval_seconds);
    }

    /**
     * Submitting an inverted interval range must be rejected.
     */
    public function testInvertedIntervalRangeIsRejected(): void
    {
        $this->artisan('ogamex:admin:assign-role', ['username' => auth()->user()->username]);

        $response = $this->from('/admin/ai-players/settings')->put('/admin/ai-players/settings', [
            'daemon_enabled' => '1',
            'max_concurrent_players' => 25,
            'default_action_interval_min' => 600,
            'default_action_interval_max' => 60,
            'default_sleep_start' => '02:00',
            'default_sleep_end' => '06:00',
            'log_retention_days' => 14,
            'autoupdate_daemon_interval_seconds' => 5,
            'autoupdate_logs_interval_seconds' => 10,
        ]);

        $response->assertRedirect('/admin/ai-players/settings');
        $response->assertSessionHas('error');
    }

    /**
     * Daemon status JSON returns a stable shape.
     */
    public function testDaemonStatusJsonShape(): void
    {
        $this->artisan('ogamex:admin:assign-role', ['username' => auth()->user()->username]);

        $response = $this->getJson('/admin/ai-players/daemon/status.json');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'now',
            'daemon' => ['status', 'is_running', 'pid', 'uptime', 'memory', 'memory_usage_bytes', 'players_processed', 'total_actions_executed'],
            'counts' => ['total_players', 'active_players', 'actions_today', 'failures_today'],
        ]);
        $response->assertJsonPath('daemon.memory_usage_bytes', fn ($v) => is_int($v));
    }

    /**
     * Activity log JSON returns only entries newer than the supplied `since` timestamp.
     */
    public function testActivityLogJsonRespectsSinceFilter(): void
    {
        $this->artisan('ogamex:admin:assign-role', ['username' => auth()->user()->username]);

        // Set up a minimal AI player + a couple of logs around a known cutoff.
        $aiUser = User::factory()->create();
        $aiPlayer = AiPlayer::create([
            'user_id' => $aiUser->id,
            'profile' => 'miner',
            'is_active' => true,
            'difficulty_level' => 1,
            'priority_building' => 5,
            'priority_research' => 5,
            'priority_fleet' => 5,
            'action_interval_min' => 60,
            'action_interval_max' => 300,
            'sleep_start' => '01:00:00',
            'sleep_end' => '07:00:00',
        ]);

        AiPlayerLog::create([
            'ai_player_id' => $aiPlayer->id,
            'action_type' => 'build',
            'action_data' => ['planet_id' => 1],
            'status' => 'success',
            'created_at' => now()->subMinutes(10),
        ]);

        $cutoff = now()->subMinutes(5)->toIso8601String();

        AiPlayerLog::create([
            'ai_player_id' => $aiPlayer->id,
            'action_type' => 'research',
            'action_data' => ['planet_id' => 1],
            'status' => 'success',
            'created_at' => now()->subMinutes(1),
        ]);

        $response = $this->getJson('/admin/ai-players/activity-log.json?since=' . urlencode($cutoff));
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertIsArray($data['entries']);
        // Only the entry created after the cutoff must be returned.
        foreach ($data['entries'] as $entry) {
            $this->assertSame('research', $entry['action_type']);
        }
    }
}
