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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
    $table->string('label');     // اسم الرابط
    $table->string('route')->nullable(); // route name أو url
    $table->string('url')->nullable();   // fallback url
    $table->unsignedBigInteger('parent_id')->nullable(); // باش نعمل dropdown
    $table->integer('order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
