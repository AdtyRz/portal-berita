<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            if (!Schema::hasColumn('organizations', 'description')) {
                $table->text('description')->nullable()->after('position');
            }
            if (!Schema::hasColumn('organizations', 'vision')) {
                $table->text('vision')->nullable()->after('description');
            }
            if (!Schema::hasColumn('organizations', 'mission')) {
                $table->text('mission')->nullable()->after('vision');
            }
            if (!Schema::hasColumn('organizations', 'achievements')) {
                $table->text('achievements')->nullable()->after('mission');
            }
            if (!Schema::hasColumn('organizations', 'contact_email')) {
                $table->string('contact_email')->nullable()->after('achievements');
            }
            if (!Schema::hasColumn('organizations', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('contact_email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['description', 'vision', 'mission', 'achievements', 'contact_email', 'contact_phone']);
        });
    }
};