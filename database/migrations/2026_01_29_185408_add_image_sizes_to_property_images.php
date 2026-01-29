<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable()->after('image_path');
            $table->string('display_path')->nullable()->after('thumbnail_path');
            $table->string('original_path')->nullable()->after('display_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_path', 'display_path', 'original_path']);
        });
    }
};
