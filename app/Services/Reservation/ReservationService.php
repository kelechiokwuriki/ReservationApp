<?php


namespace App\Services\Reservation;

use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\Reservation\ReservationSettingsRepository;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    protected $reservationRepository;
    protected $reservationSettingsRepository;
    protected $reservationModel;

    public function __construct(ReservationRepository $reservationRepository, ReservationSettingsRepository $reservationSettingsRepository,
    Reservation $reservationModel)
    {
        $this->reservationRepository = $reservationRepository;
        $this->reservationSettingsRepository = $reservationSettingsRepository;
        $this->reservationModel = $reservationModel;
    }
    public function createReservation(array $reservation): array
    {
        $restrictedUserIds = [];

        $parsedDate = Carbon::parse($reservation['reservation_datetime'][0]);

        $reservationSettings = $this->reservationSettingsRepository->latest('created_at')->first();

        $existingReservation = $this->reservationRepository->where('created_at', $parsedDate)->first();

        switch ($reservationSettings->reservationType) {
            case 'individual': {
                if ($existingReservation && $existingReservation->type === 'individual') {
                    foreach ($existingReservation->users as $user) {
                        if (!in_array($user->id, $reservation['userIds'])) {
                            $reservationCreated = $this->reservationRepository->create([
                                'type' => 'individual',
                                'contact_email' => 'test@test.com',
                                'reservation_timestamp' => $parsedDate
                            ]);
                            // sync reservation with user. Many to Many
                            $reservationCreated->users()->sync($user->id);
                        } else {
                            // user already has reservation, restrict
                            $restrictedUserIds[] = $user->id;
                        }
                    }
                }
            }
            break;

            case 'group': {
                if ($existingReservation && $existingReservation->type === 'group') {
                    $acceptedUserIds = [];

                    foreach ($existingReservation->users as $user) {
                         // if group reservation is found and all the users are for that reservation
                         // then reject them else create for those not in the exisiting reservation
                         // and reject the others
                        if (!in_array($user->id, $reservation['userIds'])) {
                            // user not part of exisiting group reservation, so accept user for now
                            $acceptedUserIds[] = $user->id;
                        } else {
                            // user already has reservation, restrict
                            $restrictedUserIds[] = $user->id;
                        }
                    }

                    // if all users are not part of an exisiting group reservation,
                    // then create
                    if (!array_diff($acceptedUserIds, $reservation['userIds'])) {
                        $reservationCreated = $this->reservationRepository->create([
                            'type' => 'group',
                            'contact_email' => 'test@test.com',
                            'reservation_timestamp' => $parsedDate
                        ]);
                        // attach reservation to all users.
                        // this also assumes the userIds are already exisiting in the app.
                        $reservationCreated->users()->sync($acceptedUserIds);
                    }
                }
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
