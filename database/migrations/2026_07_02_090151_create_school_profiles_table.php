<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('School Portal');
            $table->string('short_name')->nullable();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->year('founded_year')->nullable();
            $table->string('accreditation')->nullable();
            $table->string('principal_name')->nullable();
            
            // Social Media Links
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('tiktok')->nullable();
            
            // Social Media Embed Codes (2 Input per platform)
            $table->text('instagram_embed_1')->nullable();
            $table->text('instagram_embed_2')->nullable();
            $table->text('tiktok_embed_1')->nullable();
            $table->text('tiktok_embed_2')->nullable();
            $table->text('youtube_embed_1')->nullable();
            $table->text('youtube_embed_2')->nullable();
            $table->text('facebook_embed_1')->nullable();
            $table->text('facebook_embed_2')->nullable();
            
            // Branding
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('cover_image')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};