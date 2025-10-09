<?php

// database/migrations/2025_10_03_000000_add_form_data_to_vigsel_applications_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vigsel_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('vigsel_applications', 'form_data')) {
                $table->json('form_data')->nullable();
            }
            if (!Schema::hasColumn('vigsel_applications', 'name')) {
                $table->string('name')->nullable();
            }
            if (!Schema::hasColumn('vigsel_applications', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('vigsel_applications', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('vigsel_applications', 'source')) {
                $table->string('source')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('vigsel_applications', function (Blueprint $table) {
            $table->dropColumn(['form_data','name','email','phone','source']);
        });
    }
};
