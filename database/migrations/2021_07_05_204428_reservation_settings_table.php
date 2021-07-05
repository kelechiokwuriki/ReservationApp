<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReservationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('numberOfReservations');
            $table->enum('lengthOfReservation', ['day', 'month', 'week']);
            $table->enum('reservationType', ['individual', 'group']);
            $table->enum('reservationTimeZone', ['UTC', 'Asia/Kolkata', 'America/NewYork']);
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
        Schema::dropIfExists('reservation_settings');
    }
}
