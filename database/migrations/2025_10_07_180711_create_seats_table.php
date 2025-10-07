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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_coach_id')->constrained()->onDelete('cascade');
            $table->string('seat_number'); // e.g., A1, A2, B1, B2
            $table->integer('row_number');
            $table->integer('column_number'); // Position in row (1-4 typically)
            $table->enum('seat_type', ['window', 'aisle', 'middle']);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_reserved')->default(false); // Temporary reservation during booking
            $table->timestamp('reserved_until')->nullable(); // Reservation expiry
            $table->text('notes')->nullable(); // Special notes like "Near restroom"
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['train_coach_id', 'seat_number']);
            
            // Indexes
            $table->index('train_coach_id');
            $table->index(['is_available', 'is_reserved']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
