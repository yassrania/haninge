<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \Illuminate\Database\Migrations\Migration {
    public function up(): void
    {
        Schema::table('footer_links', function (Blueprint $table) {
            if (Schema::hasColumn('footer_links', 'label')) {
                $table->string('label')->nullable()->change();
                // أو بدلها بـ:
                // $table->string('label')->default('')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('footer_links', function (Blueprint $table) {
            if (Schema::hasColumn('footer_links', 'label')) {
                $table->string('label')->nullable(false)->change();
            }
        });
    }
};
