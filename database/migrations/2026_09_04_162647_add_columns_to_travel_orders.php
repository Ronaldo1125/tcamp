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
        Schema::table('travel_orders', function (Blueprint $table) {
            $table->integer('region_code')->after('purpose_image_filename');
            $table->integer('province_code')->after('region_code');
            $table->integer('city_code')->after('province_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_orders', function (Blueprint $table) {
            // Drops the columns if you roll back the migration
            $table->dropColumn(['region_code', 'province_code', 'city_code']);
        });
    }
};
