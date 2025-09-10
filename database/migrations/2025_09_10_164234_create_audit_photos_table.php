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
        Schema::create('audit_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_item_id')->constrained('audit_items')->cascadeOnDelete();
            $table->string('path'); // storage/app/public/... o S3 key
            $table->string('caption')->nullable();
            $table->dateTime('taken_at')->nullable();
            $table->json('meta')->nullable(); // exif, device, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_photos');
    }
};
