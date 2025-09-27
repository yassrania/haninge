<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
           $table->string('type')->default('link')->after('order'); // link | cta
            $table->boolean('new_tab')->default(false)->after('type'); // فتح في تبويب جديد
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
             $table->dropColumn(['type', 'new_tab']);

        });
    }
};
