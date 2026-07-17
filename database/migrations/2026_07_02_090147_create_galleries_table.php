<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('galleries', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->string('cover_image')->nullable();
        $table->string('status')->default('draft');
        $table->unsignedBigInteger('total_views')->default(0); // <-- TAMBAH
        $table->string('display_mode')->default('grid'); // 'grid' atau 'detailed' <-- TAMBAH
        $table->string('meta_title')->nullable();
        $table->text('meta_description')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
