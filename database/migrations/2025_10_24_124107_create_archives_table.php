<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->string('title');                // العنوان
            $table->string('slug')->unique();       // السلاج (للرابط)
            $table->date('event_date')->nullable(); // التاريخ
            $table->json('images')->nullable();     // صور متعددة (JSON)
            $table->text('excerpt')->nullable();    // ملخص اختياري
            $table->longText('body')->nullable();   // المحتوى
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'event_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
