<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->dateTime('reservation_date');
            $table->integer('total_price')->default(0);
            $table->timestamps();
            ;
            $table->integer('queue_number')->nullable();
            $table->string('invoice')->unique();

            $table->enum('status', [
                'pending',
                'confirmed',
                'in_preparation',
                'served',
                'completed',
                'canceled'
            ])->default('pending');

            // status pesanan 
            // pending
            // confirmed
            // in kitchen 
            // served
            // completed 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
