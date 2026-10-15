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
        Schema::table('travel_itineraries', function (Blueprint $table) {
             // Pass an array containing all the columns you want to delete
            $table->dropColumn(['region_code', 'province_code', 'city_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_itineraries', function (Blueprint $table) {
             // Recreate the columns in case you need to roll back
             $table->integer('region_code');
            $table->integer('province_code');
            $table->integer('city_code');
        });
    }
};
