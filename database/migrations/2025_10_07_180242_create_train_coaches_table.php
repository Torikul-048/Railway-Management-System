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
        Schema::create('train_coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained()->onDelete('cascade');
            $table->string('coach_number'); // e.g., A1, B2, C3
            $table->string('coach_name')->nullable(); // e.g., AC First Class, Chair Car
            $table->enum('coach_type', ['ac_first', 'ac_chair', 'first_class', 'second_class', 'sleeper']);
            $table->integer('total_seats');
            $table->integer('seats_per_row')->default(4); // Number of seats in a row
            $table->integer('total_rows'); // Number of rows in the coach
            $table->json('layout_config')->nullable(); // Configuration like aisle position
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['train_id', 'coach_number']);
            
            // Indexes
            $table->index('train_id');
            $table->index('coach_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_coaches');
    }
};
