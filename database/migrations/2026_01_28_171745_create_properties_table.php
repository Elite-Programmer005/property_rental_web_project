<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->decimal('price', 10, 2); // Monthly rent
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('area_sqft')->nullable(); // Optional
            $table->enum('type', ['house', 'apartment', 'condo', 'townhouse', 'villa']);
            $table->enum('status', ['available', 'rented', 'unavailable'])->default('available');
            $table->decimal('latitude', 10, 8)->nullable(); // For map
            $table->decimal('longitude', 11, 8)->nullable(); // For map
            
            // Foreign key to user (landlord)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};