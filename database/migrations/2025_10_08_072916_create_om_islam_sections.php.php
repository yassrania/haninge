<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('om_islam_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // banner | image_text | text
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('subtitle')->nullable();

            // للصور/البنرات (خزن المسار كنص)
            $table->string('banner_path')->nullable();
            $table->string('image_path')->nullable();

            // لزر "Läs mer"
            $table->string('button_label')->nullable(); // افتراضي: Läs mer
            $table->string('button_url')->nullable();

            // محتوى نصي
            $table->longText('content')->nullable();

            // ترتيب بالسحب والإفلات
            $table->integer('sort')->default(0)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('om_islam_sections');
    }
};
