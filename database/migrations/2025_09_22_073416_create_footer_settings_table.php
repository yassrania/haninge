<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_footer_settings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand_logo')->nullable();
            $table->string('brand_alt')->default('Haninge Islamiska Forum');
            $table->text('brand_text')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('opening_hours')->nullable();
            $table->json('social_links')->nullable();
            $table->string('bottom_text')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('footer_settings'); }
};
