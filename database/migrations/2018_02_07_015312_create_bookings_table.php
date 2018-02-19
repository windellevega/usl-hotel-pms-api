<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('checkin');
            $table->dateTime('checkout')
                ->nullable();
            $table->unsignedTinyInteger('numberofpax');
            $table->text('remarks')
                ->nullable();
            $table->unsignedTinyInteger('reservationstatus')
                ->nullable();
            $table->dateTime('reservationdate')
                ->nullable();
            $table->unsignedInteger('guest_id');
            $table->foreign('guest_id')
                ->references('id')
                ->on('guests');
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms');
            $table->unsignedInteger('booked_by');
            $table->foreign('booked_by')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('bookingtype_id');
            $table->foreign('bookingtype_id')
                ->references('id')
                ->on('booking_types');
            $table->decimal('bookingcharge', 8, 2)
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
