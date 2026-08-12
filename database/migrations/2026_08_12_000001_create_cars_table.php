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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model_type');
            $table->integer('year');
            $table->string('color');
            $table->enum('transmission', ['Manual', 'Automatic'])->default('Automatic');
            $table->string('plate_number')->unique();
            $table->decimal('price', 15, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['tersedia', 'dipesan', 'terjual'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
