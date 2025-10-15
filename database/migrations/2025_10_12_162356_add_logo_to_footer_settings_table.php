<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            // ضع العمود بعد email لتبقى مرتّبة (اختياري)
            $table->string('logo')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};
