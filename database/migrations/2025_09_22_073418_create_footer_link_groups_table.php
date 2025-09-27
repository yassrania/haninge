<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_footer_link_groups_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('footer_link_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('footer_link_groups'); }
};
