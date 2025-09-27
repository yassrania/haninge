<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('tjanster_pages', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->id();
        $table->string('title');            // Titel (svenska)
        $table->string('slug')->unique();   // Slug
        $table->text('content')->nullable();// Innehåll
        $table->boolean('is_active')->default(true);
        $table->integer('sort_order')->default(0);
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tjanster_pages');
    }
};
