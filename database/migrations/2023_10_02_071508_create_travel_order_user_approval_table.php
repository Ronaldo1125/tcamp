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
        Schema::create('travel_order_user_approval', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('approval_type_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('remarks');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
