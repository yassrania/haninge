<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_footer_links_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_link_group_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->string('url');
            $table->boolean('is_external')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('footer_links'); }
};
