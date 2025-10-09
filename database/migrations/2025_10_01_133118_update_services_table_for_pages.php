<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // لو الأعمدة موجودة عندك مسبقاً تجاوز تعديلها
            if (! Schema::hasColumn('services', 'title'))       $table->string('title')->after('id');
            if (! Schema::hasColumn('services', 'slug'))        $table->string('slug')->unique()->after('title');
            if (! Schema::hasColumn('services', 'subtitle'))    $table->string('subtitle')->nullable()->after('slug');
            if (! Schema::hasColumn('services', 'page_banner')) $table->string('page_banner')->nullable()->after('subtitle');
            if (! Schema::hasColumn('services', 'body'))        $table->longText('body')->nullable()->after('page_banner');
            if (! Schema::hasColumn('services', 'service_rows'))$table->json('service_rows')->nullable()->after('body');
            if (! Schema::hasColumn('services', 'published'))   $table->boolean('published')->default(true)->after('service_rows');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // احذف فقط إذا أضفناها في up
            foreach (['published','service_rows','body','page_banner','subtitle','slug','title'] as $col) {
                if (Schema::hasColumn('services', $col)) $table->dropColumn($col);
            }
        });
    }
};
