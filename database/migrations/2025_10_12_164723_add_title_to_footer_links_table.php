<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('footer_links', function (Blueprint $table) {
            if (!Schema::hasColumn('footer_links', 'title')) {
                $table->string('title')->after('id'); // اجعله أول حقل نصي واضح
            }
            if (!Schema::hasColumn('footer_links', 'url')) {
                $table->string('url')->nullable();
            }
            if (!Schema::hasColumn('footer_links', 'sort')) {
                $table->unsignedInteger('sort')->default(0);
            }
            if (!Schema::hasColumn('footer_links', 'footer_link_group_id')) {
                $table->unsignedBigInteger('footer_link_group_id')->nullable()->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('footer_links', function (Blueprint $table) {
            if (Schema::hasColumn('footer_links', 'title')) $table->dropColumn('title');
            // لا تسقط الأعمدة الأخرى إذا كانت موجودة عندك مسبقًا
        });
    }
};
