<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
    Schema::create('adult_study_applications', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('personnummer')->nullable();
        $table->string('email');
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('postal_code')->nullable();
        $table->string('city')->nullable();
        $table->string('course')->nullable();
        $table->boolean('handled')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adult_study_applications');
    }
};
