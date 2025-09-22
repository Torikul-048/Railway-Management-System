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
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->string('train_number')->unique();
            $table->string('name');
            $table->enum('type', ['express', 'local', 'mail', 'passenger', 'intercity']);
            $table->string('route');
            $table->string('source_station');
            $table->string('destination_station');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->integer('total_seats');
            $table->integer('available_seats');
            $table->decimal('fare_per_seat', 8, 2);
            $table->json('seat_configuration')->nullable(); // For storing seat layout info
            $table->text('facilities')->nullable(); // AC, Food, WiFi, etc.
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trains');
    }
};
