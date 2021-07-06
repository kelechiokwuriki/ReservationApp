<?php


namespace App\Services\Reservation;

use App\Repositories\Reservation\ReservationRepository;

class ReservationService
{
    protected $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;

    }
    public function createReservation(array $reservation)
    {
        return $this->reservationRepository->create($reservation);
    }
}
