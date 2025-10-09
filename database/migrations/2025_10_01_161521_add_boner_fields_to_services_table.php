<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Banner موجود مسبقاً عندك باسم page_banner – نتركه كما هو.

            // Prayer grid
            if (!Schema::hasColumn('services','prayer_image'))     $table->string('prayer_image')->nullable()->after('page_banner');
            if (!Schema::hasColumn('services','prayer_title'))     $table->string('prayer_title')->nullable()->after('prayer_image');
            if (!Schema::hasColumn('services','prayer_subtitle'))  $table->string('prayer_subtitle')->nullable()->after('prayer_title');
            if (!Schema::hasColumn('services','prayer_article'))   $table->longText('prayer_article')->nullable()->after('prayer_subtitle');

            // Donate box
            if (!Schema::hasColumn('services','donate_qr_image'))  $table->string('donate_qr_image')->nullable()->after('prayer_article');
            if (!Schema::hasColumn('services','donate_title'))     $table->string('donate_title')->nullable()->after('donate_qr_image');
            if (!Schema::hasColumn('services','donate_subtitle'))  $table->string('donate_subtitle')->nullable()->after('donate_title');
            if (!Schema::hasColumn('services','donate_article'))   $table->longText('donate_article')->nullable()->after('donate_subtitle');
            if (!Schema::hasColumn('services','donate_btn_text'))  $table->string('donate_btn_text')->nullable()->after('donate_article');
            if (!Schema::hasColumn('services','donate_btn_url'))   $table->string('donate_btn_url')->nullable()->after('donate_btn_text');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            foreach ([
                'prayer_image','prayer_title','prayer_subtitle','prayer_article',
                'donate_qr_image','donate_title','donate_subtitle','donate_article',
                'donate_btn_text','donate_btn_url',
            ] as $col) {
                if (Schema::hasColumn('services',$col)) $table->dropColumn($col);
            }
        });
    }
};
