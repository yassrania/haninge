<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            // لو العمود غير موجود أضِفه
            if (! Schema::hasColumn('services_page_settings', 'banner')) {
                $table->string('banner')->nullable()->after('id');
            }
            if (! Schema::hasColumn('services_page_settings', 'title')) {
                $table->string('title')->nullable()->after('banner');
            }
            if (! Schema::hasColumn('services_page_settings', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }

            // JSON (أو longText لو كان السيرفر قديم لا يدعم JSON)
            if (! Schema::hasColumn('services_page_settings', 'cards')) {
                // استخدم json، أو بدّله إلى longText إن لزم
                $table->json('cards')->nullable()->after('subtitle');
            }
            if (! Schema::hasColumn('services_page_settings', 'education_title')) {
                $table->string('education_title')->nullable()->after('cards');
            }
            if (! Schema::hasColumn('services_page_settings', 'education_items')) {
                $table->json('education_items')->nullable()->after('education_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services_page_settings', function (Blueprint $table) {
            if (Schema::hasColumn('services_page_settings', 'banner')) {
                $table->dropColumn('banner');
            }
            if (Schema::hasColumn('services_page_settings', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('services_page_settings', 'subtitle')) {
                $table->dropColumn('subtitle');
            }
            if (Schema::hasColumn('services_page_settings', 'cards')) {
                $table->dropColumn('cards');
            }
            if (Schema::hasColumn('services_page_settings', 'education_title')) {
                $table->dropColumn('education_title');
            }
            if (Schema::hasColumn('services_page_settings', 'education_items')) {
                $table->dropColumn('education_items');
            }
        });
    }
};
