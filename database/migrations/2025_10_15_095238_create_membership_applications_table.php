<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('personal_number')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('apply_date')->nullable();

            $table->enum('signature_type', ['draw','type','upload'])->default('draw');
            $table->string('signature_image_path')->nullable();
            $table->string('signature_text')->nullable();

            $table->string('pdf_path')->nullable();

            $table->ipAddress('ip')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_applications');
    }
};
