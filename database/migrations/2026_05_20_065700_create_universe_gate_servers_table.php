<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('universe_gate_servers', function (Blueprint $table) {
            $table->id();
            $table->string('universe_identifier', 64)->unique();
            $table->string('name', 120);
            $table->string('base_url', 255);
            $table->string('status', 32)->default('pending');
            $table->string('registration_direction', 16)->default('outgoing');
            $table->string('shared_secret', 255);
            $table->timestamp('registered_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universe_gate_servers');
    }
};
