<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('nyheter', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();        // kort text
            $table->longText('body')->nullable();         // stor text (rich)
            $table->string('image_path')->nullable();     // bild
            $table->boolean('published')->default(true);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('nyheter');
    }
};
