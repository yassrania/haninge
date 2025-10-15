// database/migrations/2025_10_09_000001_create_stod_mosken_sections_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stod_mosken_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // banner (لو حبيت لاحقاً), image_text, image, text
            $table->integer('sort')->default(0);

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('slug')->nullable();

            $table->longText('content')->nullable();      // نص (rich)
            $table->string('image_path')->nullable();     // صورة أساسية
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->enum('image_position', ['left','right'])->nullable(); // للصورة+النص

            $table->boolean('published')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('stod_mosken_sections');
    }
};
