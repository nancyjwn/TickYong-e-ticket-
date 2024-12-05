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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->integer('quantity')->default(1);
            $table->enum('status', ['pending', 'approved', 'canceled'])->default('pending');
            $table->decimal('total_price', 12, 2);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
