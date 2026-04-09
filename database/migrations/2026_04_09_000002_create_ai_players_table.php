<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ai_players', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('profile', 20)->default('neutral');
            $table->boolean('is_active')->default(false);
            $table->tinyInteger('difficulty_level')->unsigned()->default(3);
            $table->tinyInteger('priority_building')->unsigned()->default(5);
            $table->tinyInteger('priority_research')->unsigned()->default(5);
            $table->tinyInteger('priority_fleet')->unsigned()->default(5);
            $table->timestamp('last_action_at')->nullable();
            $table->timestamp('next_action_at')->nullable();
            $table->unsignedInteger('action_interval_min')->default(60);
            $table->unsignedInteger('action_interval_max')->default(300);
            $table->time('sleep_start')->default('01:00');
            $table->time('sleep_end')->default('07:00');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_players');
    }
};
