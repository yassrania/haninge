<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            // نحول cta_subtitle من string (VARCHAR) إلى TEXT
            $table->text('cta_subtitle')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            // نرجّعها لو رجعنا (اختياري)
            $table->string('cta_subtitle', 255)->nullable()->change();
        });
    }
};
