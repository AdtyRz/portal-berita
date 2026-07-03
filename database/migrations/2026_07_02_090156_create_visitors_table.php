<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('url')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('visited_at');
            $table->timestamps();

            $table->index(['visited_at']);
            $table->index(['ip_address', 'visited_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
