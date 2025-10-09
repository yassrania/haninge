<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('services_page_settings', 'cards_section_title')) {
                $table->string('cards_section_title')->nullable();
            }
            if (! Schema::hasColumn('services_page_settings', 'cards_section_subtitle')) {
                $table->string('cards_section_subtitle')->nullable();
            }
            if (! Schema::hasColumn('services_page_settings', 'cards_section_desc')) {
                // لو MySQL عندك قديم وما يدعم JSON، خليه longText
                $table->longText('cards_section_desc')->nullable();
            }

            // تأكد أن education_title موجود ومسموح يكون null (لو كان عندك بالفعل تجاهل السطر)
            if (! Schema::hasColumn('services_page_settings', 'education_title')) {
                $table->string('education_title')->nullable();
            }

            if (! Schema::hasColumn('services_page_settings', 'education_items')) {
                // لو تفضّل JSON واستضافتك تدعمه استبدل بـ ->json('education_items')
                $table->longText('education_items')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            if (Schema::hasColumn('services_page_settings', 'cards_section_title')) {
                $table->dropColumn('cards_section_title');
            }
            if (Schema::hasColumn('services_page_settings', 'cards_section_subtitle')) {
                $table->dropColumn('cards_section_subtitle');
            }
            if (Schema::hasColumn('services_page_settings', 'cards_section_desc')) {
                $table->dropColumn('cards_section_desc');
            }
            if (Schema::hasColumn('services_page_settings', 'education_items')) {
                $table->dropColumn('education_items');
            }
            // غالبًا ما نحذف education_title لو كانت موجودة من قبل — اتركه أو احذفه حسب حاجتك
        });
    }
};
