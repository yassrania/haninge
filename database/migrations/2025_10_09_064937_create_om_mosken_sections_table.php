<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('om_mosken_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // banner | image_text | text
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('subtitle')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('image_position', ['left', 'right'])->default('left'); // Bildposition
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->longText('content')->nullable();
            $table->integer('sort')->default(0)->index();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('om_mosken_sections');
    }
};
