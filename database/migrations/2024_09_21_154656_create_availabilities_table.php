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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User/Advisor relation
            $table->string('type')->nullable();
            $table->date('start_date'); // Start date of availability
            $table->date('end_date')->nullable(); // End date (for ranges)
            $table->time('start_time'); // Time of availability
            $table->time('end_time')->nullable(); // Optional end time (for flexibility)
            $table->string('timezone')->default('UTC'); // Timezone
            $table->boolean('is_booked')->default(false); // Track if the slot is booked
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
