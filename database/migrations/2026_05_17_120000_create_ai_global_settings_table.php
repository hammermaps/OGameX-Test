<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ai_global_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('daemon_enabled')->default(true);
            $table->unsignedInteger('max_concurrent_players')->default(50);
            $table->unsignedInteger('default_action_interval_min')->default(60);
            $table->unsignedInteger('default_action_interval_max')->default(300);
            $table->string('default_sleep_start', 5)->default('01:00');
            $table->string('default_sleep_end', 5)->default('07:00');
            $table->unsignedInteger('log_retention_days')->default(30);
            $table->unsignedInteger('autoupdate_daemon_interval_seconds')->default(5);
            $table->unsignedInteger('autoupdate_logs_interval_seconds')->default(10);
            $table->timestamps();
        });

        DB::table('ai_global_settings')->insert([
            'daemon_enabled' => true,
            'max_concurrent_players' => 50,
            'default_action_interval_min' => 60,
            'default_action_interval_max' => 300,
            'default_sleep_start' => '01:00',
            'default_sleep_end' => '07:00',
            'log_retention_days' => 30,
            'autoupdate_daemon_interval_seconds' => 5,
            'autoupdate_logs_interval_seconds' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_global_settings');
    }
};
