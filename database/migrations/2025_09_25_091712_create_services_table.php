<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');               // Titel på sidan
            $table->string('subtitle')->nullable();// Undertitel
            $table->string('slug')->unique();      // URL slug, ex: islamisk-begravning

            // Banner + rader innehåll (upp till 4 rader)
            $table->string('page_banner')->nullable();
            $table->json('service_rows')->nullable(); // [{photo,title,subtitle,description}...]

            // Utbildning (valfri per sida)
            $table->string('utbildning_vuxna_photo')->nullable();
            $table->string('utbildning_vuxna_title')->nullable();
            $table->text   ('utbildning_vuxna_desc')->nullable();

            $table->string('utbildning_barn_photo')->nullable();
            $table->string('utbildning_barn_title')->nullable();
            $table->text   ('utbildning_barn_desc')->nullable();

            $table->boolean('published')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
