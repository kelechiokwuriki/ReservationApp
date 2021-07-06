<?php

namespace App\Repositories\Reservation;

use App\Repositories\Base\BaseRepository;
use App\Reservation;

class ReservationRepository extends BaseRepository
{
    protected $reservationModel;

    public function __construct(Reservation $reservationModel)
    {
        parent::__construct($reservationModel);
    }
}
