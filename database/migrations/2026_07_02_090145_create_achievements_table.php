<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('achievement_type')->nullable();
            $table->string('achiever_name')->nullable();
            $table->string('competition_name')->nullable();
            $table->enum('level', ['school', 'district', 'city', 'province', 'national', 'international'])->default('school');
            $table->enum('rank', ['1st', '2nd', '3rd', 'honorable', 'participant'])->nullable();
            $table->date('achievement_date')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('total_views')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'achievement_date']);
            $table->index(['level', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
