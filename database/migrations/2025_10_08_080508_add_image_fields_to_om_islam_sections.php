<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('om_islam_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('om_islam_sections', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }
            if (!Schema::hasColumn('om_islam_sections', 'content')) {
                $table->longText('content')->nullable()->after('subtitle');
            }
            if (!Schema::hasColumn('om_islam_sections', 'image_position')) {
                $table->enum('image_position', ['left', 'right'])->default('left')->after('image_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('om_islam_sections', function (Blueprint $table) {
            if (Schema::hasColumn('om_islam_sections', 'image_position')) {
                $table->dropColumn('image_position');
            }
            // عادة لا نحذف المحتوى/العناوين عند الرجوع، لكن لو تحتاج:
            // if (Schema::hasColumn('om_islam_sections', 'content')) $table->dropColumn('content');
            // if (Schema::hasColumn('om_islam_sections', 'subtitle')) $table->dropColumn('subtitle');
        });
    }
};
