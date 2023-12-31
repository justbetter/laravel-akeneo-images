<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akeneo_images', function (Blueprint $table): void {
            $table->id();
            $table->string('disk');
            $table->string('path');
            $table->string('hash')->nullable();
            $table->dateTime('processed_at')->nullable();
            $table->string('processed_path')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akeneo_images');
    }
};
