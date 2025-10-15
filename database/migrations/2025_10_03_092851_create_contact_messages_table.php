<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
    $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
    $table->string('source_slug')->nullable();
    $table->string('name');
    $table->string('email');
    $table->string('phone')->nullable();
    $table->string('subject')->nullable();
    $table->text('message');
    $table->timestamp('consent_at')->nullable();
    $table->string('ip', 45)->nullable();
    $table->string('user_agent', 255)->nullable();
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('contact_messages');
    }
};
