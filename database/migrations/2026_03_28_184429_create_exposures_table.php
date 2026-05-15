<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exposures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('channel_id')->constrained('exposure_channels')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('publication_price', 12, 2)->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('leads_count')->default(0);
            $table->string('status');
            $table->string('source_url')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exposures');
    }
};
