<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ai_player_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ai_player_id');
            $table->foreign('ai_player_id')->references('id')->on('ai_players')->onDelete('cascade');
            $table->string('action_type', 30);
            $table->json('action_data')->nullable();
            $table->string('status', 10)->default('success');
            $table->text('error_message')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_player_logs');
    }
};
