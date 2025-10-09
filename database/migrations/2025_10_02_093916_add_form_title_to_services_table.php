<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_form_title_to_services.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('services', function (Blueprint $table) {
            $table->string('form_title')->nullable();
        });
    }
    public function down(): void {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('form_title');
        });
    }
};
