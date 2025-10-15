<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('footer_settings', 'bankgiro')) {
                $table->string('bankgiro')->nullable()->after('logo');
            }
            if (!Schema::hasColumn('footer_settings', 'swish_number')) {
                $table->string('swish_number')->nullable()->after('bankgiro');
            }
        });
    }

    public function down(): void
    {
        Schema::table('footer_settings', function (Blueprint $table) {
            if (Schema::hasColumn('footer_settings', 'swish_number')) {
                $table->dropColumn('swish_number');
            }
            if (Schema::hasColumn('footer_settings', 'bankgiro')) {
                $table->dropColumn('bankgiro');
            }
        });
    }
};
