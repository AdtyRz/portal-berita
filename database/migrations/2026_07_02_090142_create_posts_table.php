<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->boolean('breaking_news')->default(false);
            $table->timestamp('publish_date')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('keywords')->nullable();
            $table->unsignedBigInteger('total_views')->default(0);
            $table->unsignedBigInteger('total_likes')->default(0);
            $table->unsignedBigInteger('total_comments')->default(0);
            $table->unsignedBigInteger('total_shares')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'publish_date']);
            $table->index(['featured', 'status']);
            $table->index(['breaking_news', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
