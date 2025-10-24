<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            // أضف العمود إذا لم يكن موجودًا، بدون after()
            if (! Schema::hasColumn('membership_applications', 'Personnummer')) {
                $table->string('Personnummer')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('membership_applications', function (Blueprint $table) {
            if (Schema::hasColumn('membership_applications', 'Personnummer')) {
                $table->dropColumn('Personnummer');
            }
        });
    }
};
