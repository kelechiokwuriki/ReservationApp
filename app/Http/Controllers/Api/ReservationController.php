<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Reservation\ReservationService;
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function store(Request $reservationRequest)
    {
        try {
            $result = $this->reservationService->createReservation($reservationRequest->all());
            return response()->json($result, 200);
        } catch(Exception $e) {
            return response()->json($e->getMessage(), '400');
        }
    }
}
