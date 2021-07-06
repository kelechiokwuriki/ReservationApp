<?php


namespace App\Services\Reservation;

use App\Repositories\Reservation\ReservationRepository;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;

    }
    public function createReservation(array $reservation)
    {
        Log::debug($reservation);
        // return $this->reservationRepository->create($reservation);
    }
}
