<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            $table->string('education_subtitle')->nullable()->after('education_title');
            $table->longText('education_description')->nullable()->after('education_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            $table->dropColumn(['education_subtitle', 'education_description']);
        });
    }
};
