<?php

namespace App\Repositories\Reservation;

use App\Repositories\Base\BaseRepository;
use App\ReservationSettings;

class ReservationSettingsRepository extends BaseRepository
{
    protected $reservationSettingsModel;

    public function __construct(ReservationSettings $reservationSettingsModel)
    {
        parent::__construct($reservationSettingsModel);
    }
}
