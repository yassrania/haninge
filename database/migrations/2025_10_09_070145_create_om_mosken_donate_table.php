<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('om_mosken_donate', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(false);
            $table->string('title')->nullable();       // dTitle
            $table->string('subtitle')->nullable();    // dSub
            $table->longText('body')->nullable();      // dBody (اختياري)
            $table->string('button_label')->nullable();// dBtnTxt (اختياري)
            $table->string('button_url')->nullable();  // dBtnUrl (اختياري)
            $table->string('qr_path')->nullable();     // صورة QR/Swish
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('om_mosken_donate');
    }
};
