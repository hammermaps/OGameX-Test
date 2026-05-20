<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('universe_gate_enabled')->default(false)->after('is_ai_player');
            $table->unsignedBigInteger('universe_gate_cooldown_until')->nullable()->after('universe_gate_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['universe_gate_enabled', 'universe_gate_cooldown_until']);
        });
    }
};
