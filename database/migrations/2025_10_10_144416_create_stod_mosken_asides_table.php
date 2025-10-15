// database/migrations/2025_10_09_000002_create_stod_mosken_asides_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('stod_mosken_asides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();          // نص (rich)
            $table->string('image_path')->nullable();      // صورة جانبية (QR أو بانر صغير)
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->string('extra_image_path')->nullable(); // صورة إضافية (إن رغبت)
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('stod_mosken_asides');
    }
};
