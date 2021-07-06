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

    public function update(Request $request, $id)
    {
        return $this->reservationSettingsService->updateSettings($id, $request->all());
    }

    public function store(Request $request, $id)
    {
        return $this->reservationSettingsService->updateSettings($id, $request->all());
    }
}
