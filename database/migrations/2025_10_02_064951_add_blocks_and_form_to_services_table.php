<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services','blocks'))               $table->json('blocks')->nullable()->after('body');
            if (!Schema::hasColumn('services','form_fields'))          $table->json('form_fields')->nullable()->after('blocks');
            if (!Schema::hasColumn('services','form_email_to'))        $table->string('form_email_to')->nullable()->after('form_fields');
            if (!Schema::hasColumn('services','form_success_message')) $table->string('form_success_message')->nullable()->after('form_email_to');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            foreach (['form_success_message','form_email_to','form_fields','blocks'] as $col) {
                if (Schema::hasColumn('services',$col)) $table->dropColumn($col);
            }
        });
    }
};
