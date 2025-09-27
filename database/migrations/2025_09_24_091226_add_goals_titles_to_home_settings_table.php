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
        $table->string('goals_title')->nullable()->after('goals');     // أو بعد الحقل اللي يناسبك
        $table->string('goals_accent')->nullable()->after('goals_title');
    });
}

public function down(): void
{
    Schema::table('home_settings', function (Blueprint $table) {
        $table->dropColumn(['goals_title', 'goals_accent']);
    });
}

};
