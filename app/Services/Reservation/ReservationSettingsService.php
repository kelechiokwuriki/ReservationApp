<?php


namespace App\Services\Reservation;

use App\Repositories\Reservation\ReservationSettingsRepository;

class ReservationSettingsService
{
    protected $reservationSettingsRepository;

    public function __construct(ReservationSettingsRepository $reservationSettingsRepository)
    {
        $this->reservationSettingsRepository = $reservationSettingsRepository;

    }
    public function getSettings()
    {
        return $this->reservationSettingsRepository->latest('created_at')->first();
    }

    public function saveSettings(array $settings)
    {
        return $this->reservationSettingsRepository->create($settings);
    }
}
