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

            $table->string('callsign')->unique();

            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();

         
            $table->boolean('on_ground')->default(false);

           
            $table->float('velocity')->nullable(); 
            $table->float('heading')->nullable();  

        
            $table->float('baro_altitude')->nullable(); 
            $table->float('geo_altitude')->nullable();  

           
            $table->unsignedBigInteger('last_contact')->nullable(); 
            $table->unsignedBigInteger('snapshot_time')->nullable(); 

            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
