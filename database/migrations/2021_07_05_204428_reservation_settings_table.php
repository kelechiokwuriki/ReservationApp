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
            $table->string('lengthOfReservation');
            $table->string('reservationType');
            $table->string('reservationTimeZone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
