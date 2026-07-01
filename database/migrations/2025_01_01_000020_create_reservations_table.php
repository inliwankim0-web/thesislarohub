<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            // Guest info (for walk-ins or non-logged-in renters)
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('contact');
            // Booking details
            $table->date('date');
            $table->time('start_time');
            $table->integer('duration_hours');
            $table->time('end_time');
            $table->decimal('total_amount', 10, 2);
            $table->text('notes')->nullable();
            // Status: pending | confirmed | rejected | cancelled | completed
            $table->string('status')->default('pending');
            // Payment
            $table->string('payment_method')->default('gcash'); // gcash | cash
            $table->string('payment_reference')->nullable();
            $table->string('payment_status')->default('unpaid'); // unpaid | paid | verified
            // Walk-in flag (created by staff)
            $table->boolean('is_walk_in')->default(false);
            $table->timestamps();
        });

        // SAW preference weights per search
        Schema::create('recommendation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sport');
            $table->date('search_date');
            $table->time('search_time');
            $table->integer('duration_hours');
            // Weights (sum = 1.0)
            $table->decimal('weight_price', 4, 2)->default(0.40);
            $table->decimal('weight_rating', 4, 2)->default(0.35);
            $table->decimal('weight_distance', 4, 2)->default(0.25);
            $table->json('results')->nullable(); // ranked venue IDs with SAW scores
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_logs');
        Schema::dropIfExists('reservations');
    }
};
