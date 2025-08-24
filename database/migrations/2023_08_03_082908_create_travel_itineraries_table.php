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
        Schema::create('travel_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_order_id')->constrained()->cascadeOnDelete();
            $table->date('itinerary_date');
            $table->integer('region_code');
            $table->integer('province_code');
            $table->integer('city_code');
            $table->time('estimated_time_of_departure');
            $table->time('estimated_time_of_arrival');
            $table->tinyInteger('transportation_id')->constrained();
            $table->double('transportation_price', 8, 2);
            $table->tinyInteger('with_lodging')->default(0);
            $table->tinyInteger('with_breakfast')->default(0);
            $table->tinyInteger('with_lunch')->default(0);
            $table->tinyInteger('with_snack')->default(0);
            $table->tinyInteger('with_incidental_expenses')->default(0);
            $table->double('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_itineraries');
    }
};
