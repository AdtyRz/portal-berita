<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->morphs('reactable');
            $table->enum('type', ['like', 'love', 'care', 'wow', 'sad', 'angry'])->default('like');
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'reactable_id', 'reactable_type', 'type'], 'unique_user_reaction');
            $table->unique(['ip_address', 'reactable_id', 'reactable_type', 'type'], 'unique_ip_reaction');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
