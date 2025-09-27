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
    Schema::table('home_settings', function (Blueprint $table) {
        $table->string('intro_title')->nullable()->after('hero_image');
        $table->string('intro_accent')->nullable()->after('intro_title');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('home_settings', function (Blueprint $table) {
        $table->dropColumn(['intro_title', 'intro_accent']);
    });
}
};
