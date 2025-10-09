<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services_page_settings', function (Blueprint $table) {
            $table->id();
            // Banner
            $table->string('banner_image')->nullable();
            $table->string('banner_title')->nullable()->default('Våra tjänster');
            $table->string('banner_subtitle')->nullable()->default('Tjänster för församlingens medlemmar och besökare');

            // Services rows (repeater)
            $table->json('service_rows')->nullable();

            // Utbildning cards (2 كروت)
            $table->json('education_cards')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_page_settings');
    }
};
