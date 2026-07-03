<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('link')->nullable();
            $table->enum('position', ['header', 'sidebar', 'footer', 'popup'])->default('sidebar');
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['position', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
