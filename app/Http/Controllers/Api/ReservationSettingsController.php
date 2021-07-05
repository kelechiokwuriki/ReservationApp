<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Reservation\ReservationSettingsService;
use Illuminate\Http\Request;

class ReservationSettingsController extends Controller
{
    protected $reservationSettingsService;

    public function __construct(ReservationSettingsService $reservationSettingsService) {
        $this->reservationSettingsService = $reservationSettingsService;
    }

    public function index()
    {
        return $this->reservationSettingsService->getSettings();
    }

}
