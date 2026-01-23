<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();

            // Flight info
            $table->string('callsign')->unique();

            // Position
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();

            // Status
            $table->boolean('on_ground')->default(false);

            // Movement
            $table->float('velocity')->nullable(); // m/s
            $table->float('heading')->nullable();  // degrees

            // Altitude
            $table->float('baro_altitude')->nullable(); // meters
            $table->float('geo_altitude')->nullable();  // meters

            // Timestamps from API
            $table->unsignedBigInteger('last_contact')->nullable(); // unix time
            $table->unsignedBigInteger('snapshot_time')->nullable(); // API "time"

            // Laravel timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
