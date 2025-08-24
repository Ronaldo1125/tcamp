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
        Schema::create('travel_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('to_code');
            $table->string('purpose');
            $table->string('purpose_image_filename');
            $table->string('destination');
            $table->date('travel_departure_date');
            $table->date('travel_arrival_date');
            $table->foreignId('fund_source_id')->constrained();
            $table->integer('pap_id')->default(0);
            $table->string('other_pap_name')->nullable();
            $table->tinyInteger('is_travel_related_to_training')->default(0);
            $table->tinyInteger('is_cash_advance')->default(0);
            $table->tinyInteger('is_approved_by_budget_officer')->default(0);
            $table->tinyInteger('is_approved_by_immediate_supervisor')->default(0);
            $table->tinyInteger('is_approved_by_management')->default(0);
            $table->double('grand_total', 8,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_orders');
    }
};
