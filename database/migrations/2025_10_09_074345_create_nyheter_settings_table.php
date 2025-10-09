<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('nyheter_settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_path')->nullable();
            $table->string('title')->nullable();      // عنوان البانر
            $table->string('subtitle')->nullable();   // سطر تحت العنوان
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('nyheter_settings');
    }
};
