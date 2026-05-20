<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('universe_gate_missions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('universe_gate_server_id')->constrained()->cascadeOnDelete();
            $table->integer('user_id', false, true)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->integer('planet_id_from', false, true)->nullable();
            $table->foreign('planet_id_from')->references('id')->on('planets')->nullOnDelete();
            $table->unsignedBigInteger('fleet_mission_id')->nullable();
            $table->foreign('fleet_mission_id')->references('id')->on('fleet_missions')->nullOnDelete();
            $table->string('remote_mission_uuid', 64)->nullable()->index();
            $table->string('direction', 16);
            $table->string('status', 32)->default('pending');
            $table->integer('mission_type')->default(1);
            $table->integer('target_galaxy');
            $table->integer('target_system');
            $table->integer('target_position');
            $table->integer('target_type');
            $table->json('fleet_payload');
            $table->json('resource_payload')->nullable();
            $table->json('result_payload')->nullable();
            $table->json('return_payload')->nullable();
            $table->string('idempotency_key', 120);
            $table->unique(['universe_gate_server_id', 'idempotency_key']);
            $table->unsignedBigInteger('cooldown_until')->nullable();
            $table->timestamp('remote_dispatched_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universe_gate_missions');
    }
};
