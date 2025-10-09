<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('services_page_settings', 'cards_section_description')) {
                $table->text('cards_section_description')->nullable()->after('cards_section_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            if (Schema::hasColumn('services_page_settings', 'cards_section_description')) {
                $table->dropColumn('cards_section_description');
            }
        });
    }
};
