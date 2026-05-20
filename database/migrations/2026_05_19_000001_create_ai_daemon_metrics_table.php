<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ai_daemon_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memory_usage_bytes')->default(0);
            $table->unsignedInteger('players_processed')->default(0);
            $table->timestamp('recorded_at');

            $table->index('recorded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_daemon_metrics');
    }
};
