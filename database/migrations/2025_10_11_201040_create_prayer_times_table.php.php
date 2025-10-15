<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('prayer_times', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique(); // تاريخ اليوم
            $table->string('fajr', 5)->nullable();
            $table->string('sunrise', 5)->nullable();
            $table->string('dhuhr', 5)->nullable();
            $table->string('asr', 5)->nullable();
            $table->string('maghrib', 5)->nullable();
            $table->string('isha', 5)->nullable();
            $table->string('mosque_guid')->nullable();
            $table->string('source')->default('my-masjid-sharescreen');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('prayer_times');
    }
};
