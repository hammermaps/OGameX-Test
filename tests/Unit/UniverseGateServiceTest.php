<?php

namespace Tests\Unit;

use OGame\Models\UniverseGateServer;
use OGame\Services\FleetMissionService;
use OGame\Services\SettingsService;
use OGame\Services\UniverseGateService;
use Tests\TestCase;

class UniverseGateServiceTest extends TestCase
{
    public function testCooldownHasHighMinimum(): void
    {
        $service = $this->makeService(['universe_gate_cooldown_seconds' => '60']);

        $this->assertSame(3600, $service->cooldownSeconds());
    }

    public function testCostMultiplierHasMinimum(): void
    {
        $service = $this->makeService(['universe_gate_deuterium_cost_multiplier' => '0']);

        $this->assertSame(1, $service->deuteriumCostMultiplier());
    }

    public function testPayloadSignatureIsDeterministic(): void
    {
        $service = $this->makeService([]);
        $server = new UniverseGateServer(['shared_secret' => 'abcdefghijklmnopqrstuvwxyz123456']);

        $signature = $service->signPayload($server, '1000', 'nonce', '{"ok":true}');

        $this->assertSame(
            hash_hmac('sha256', '1000.nonce.{"ok":true}', 'abcdefghijklmnopqrstuvwxyz123456'),
            $signature
        );
    }

    /**
     * @param array<string,string> $settings
     */
    private function makeService(array $settings): UniverseGateService
    {
        $settingsService = $this->createMock(SettingsService::class);
        $settingsService->method('get')->willReturnCallback(
            fn (string $key, string|int $default = ''): string => $settings[$key] ?? (string)$default
        );
        $settingsService->method('universeName')->willReturn('Test Universe');

        return new UniverseGateService(
            $settingsService,
            $this->createMock(FleetMissionService::class)
        );
    }
}
