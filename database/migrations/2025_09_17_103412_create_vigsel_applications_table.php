<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('vigsel_applications', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('personnummer')->nullable();
        $table->string('email');
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('postal_code')->nullable();
        $table->string('city')->nullable();
        $table->date('requested_date')->nullable();
        $table->boolean('handled')->default(false);
        $table->timestamps();
    });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vigsel_applications');
    }
};
