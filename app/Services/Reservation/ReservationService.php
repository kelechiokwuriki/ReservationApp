<?php


namespace App\Services\Reservation;

use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\Reservation\ReservationSettingsRepository;
use App\Reservation;
use App\Services\Utility\Utilities as UtilityUtilities;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    protected $reservationRepository;
    protected $reservationSettingsRepository;
    protected $reservationModel;
    protected $utilityService;

    public function __construct(ReservationRepository $reservationRepository, ReservationSettingsRepository $reservationSettingsRepository,
    Reservation $reservationModel, UtilityUtilities $utilityService)
    {
        $this->reservationRepository = $reservationRepository;
        $this->reservationSettingsRepository = $reservationSettingsRepository;
        $this->reservationModel = $reservationModel;
        $this->utilityService = $utilityService;
    }
    public function createReservation(array $reservation): array
    {
        $restrictedUserIds = [];
        $parsedDate = Carbon::parse($reservation['reservation_datetime'][0]);
        $reservationSettings = $this->reservationSettingsRepository->latest('created_at')->first();


        switch ($reservationSettings->reservationType) {
            case 'individual':
                foreach($reservation['userIds'] as $userId) {
                    // check if there is a reservation for the userid
                    $user = User::where('id', $userId)->exists();

                    if (!$user) {
                        throw new Exception('User with id '. $userId . ' does not exist in system');
                    }

                    $existingReservation = Reservation::whereHas('users', function($query) use ($userId){
                        $query->where('user_id', $userId);
                    })->get();

                    // if there is any atall
                    if (count($existingReservation) > 0) {
                        $restrictedUserIds[] = $userId;
                    } else {
                        $reservation = $this->reservationRepository->create([
                            'type' => $reservationSettings->reservationType,
                            'contact_email' => 'test@test.com',
                            'reservation_timestamp' => $parsedDate
                        ]);
                        $reservation->users()->sync($userId);
                    }
                }

            break;

            case 'group':
                $acceptedUserIds = [];

                foreach($reservation['userIds'] as $userId) {
                    //check if user in the system
                    if (!User::find($userId)) {
                        throw new Exception('User with id ' . $userId . ' does not exist in the system');
                    }

                    // check if there is a reservation for the userid
                    $existingReservation = Reservation::whereHas('users', function($q) use ($userId){
                        $q->where('user_id', $userId);
                    })->get();

                    // if there is any atall
                    if (isset($existingReservation)) {
                        $restrictedUserIds[] = $userId;
                    } else {
                        $acceptedUserIds[] = $userId;
                    }
                }

                if ($this->utilityService->arrays_are_equal($reservation['userIds'], $acceptedUserIds)) {
                    $reservation = $this->reservationRepository->create([
                        'type' => $reservationSettings->reservationType,
                        'contact_email' => 'test@test.com',
                        'reservation_timestamp' => $parsedDate
                    ]);
                    $reservation->users()->sync($acceptedUserIds);
                }
            break;

            default:
                break;

        }

        return [
            "is_booking_restricted" => count($restrictedUserIds) > 0 ? true : false,
            "restricted_user_ids" => $restrictedUserIds
        ];
    }
}
