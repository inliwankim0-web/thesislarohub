<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('address');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('contact')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rating', 3, 2)->default(4.00);
            $table->boolean('is_active')->default(true);
            $table->string('color')->default('from-blue-500 to-indigo-600');
            $table->string('emoji')->default('🏟️');
            $table->timestamps();
        });

        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('sport'); // Basketball, Badminton, etc.
            $table->string('label')->nullable(); // e.g. "Basketball Court"
            $table->string('time_slot')->nullable(); // daytime | night | 7am-4pm | 4pm-10pm | any
            $table->decimal('price_per_hour', 10, 2);
            $table->boolean('has_lights')->default(true);
            $table->integer('court_count')->default(1);
            $table->boolean('is_monthly')->default(false); // for gym memberships
            $table->string('rate_type')->default('hourly'); // hourly | monthly
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_booked')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_slots');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('venues');
    }
};
