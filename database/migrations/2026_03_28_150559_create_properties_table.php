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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('property_type_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('district_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('segment')->nullable();
            $table->string('address');
            $table->decimal('area', 12, 2);
            $table->decimal('price', 15, 2);
            $table->decimal('price_per_sqm', 15, 2);
            $table->string('status');
            $table->foreignId('responsible_user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
