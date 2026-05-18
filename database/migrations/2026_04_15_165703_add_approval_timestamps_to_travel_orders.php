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
            $table->timestamp('immediate_supervisor_approved_at')->nullable()->after('grand_total');
            $table->timestamp('management_approved_at')->nullable()->after('immediate_supervisor_approved_at');
            $table->timestamp('budget_officer_approved_at')->nullable()->after('management_approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_orders', function (Blueprint $table) {
            //
        });
    }
};
