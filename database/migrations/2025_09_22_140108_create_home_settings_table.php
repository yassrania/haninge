<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();

            // Hero / Slider
            $table->string('hero_mode')->default('slider'); // slider | single_video | single_image
            $table->string('hero_video_file')->nullable();  // upload mp4/webm
            $table->string('hero_video_url')->nullable();   // YouTube/Vimeo
            $table->string('hero_image')->nullable();       // fallback image
            $table->json('slides')->nullable();             // [{type, image, video_url, video_file, caption, button_text, button_url}]

            // About (Om moskén)
            $table->string('about_title')->nullable();
            $table->text('about_body')->nullable();
            $table->string('about_image')->nullable();

            // Goals (Våra mål)
            $table->json('goals')->nullable(); // [{title, body, image}]

            // Pillars of Islam (Islams pelare)
            $table->json('pillars')->nullable(); // [{title, body, icon}]

            // Prayers/players block (generic)
            $table->string('prayer_title')->nullable();
            $table->text('prayer_body')->nullable();
            $table->string('prayer_button_text')->nullable();
            $table->string('prayer_button_url')->nullable();

            // Services section
            $table->string('services_title')->nullable();
            $table->text('services_desc')->nullable();
            $table->json('services')->nullable(); // [{title, body, image, button_text, button_url}]

            // CTA
            $table->string('cta_title')->nullable();
            $table->string('cta_subtitle')->nullable();
            $table->string('cta_button_text')->nullable();
            $table->string('cta_button_url')->nullable();

            // Senaste nytt
            $table->boolean('show_latest_news')->default(true);
            $table->unsignedInteger('latest_news_limit')->default(6);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('home_settings');
    }
};
