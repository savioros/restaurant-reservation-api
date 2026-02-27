<?php

namespace App\Services;

use App\Exceptions\CreateReservationException;
use App\Exceptions\ExpiredTokenException;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\ReservationConflictException;
use App\Exceptions\RestaurantClosedException;
use App\Models\BusinessHour;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Repositories\BusinessHourRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class ReservationService
{
    public function __construct(
        private ReservationRepository $reservationRepository,
        private BusinessHourRepository $businessHourRepository
    )
    {}

    public function create(Restaurant $restaurant, array $data): Reservation
    {
        $date = Carbon::parse($data['reservation_date']);

        if ($date->isPast() && !$date->isToday()) {
            throw new Exception('You cannot book on past dates.');
        }

        $businessHour = $this->businessHourRepository->findByDayOfWeek($restaurant->id, $date->dayOfWeek);

        if (!$businessHour || $businessHour->is_closed) {
            throw new RestaurantClosedException('Restaurant closed on this day');
        }

        $startReservation = Carbon::parse($data['start_time']);
        $endReservation = Carbon::parse($data['end_time']);
        $openTimeRestaurant  = Carbon::parse($businessHour->open_time);
        $closeTimeRestaurant = Carbon::parse($businessHour->close_time);

        if ($startReservation->lt($openTimeRestaurant) || $endReservation->gte($closeTimeRestaurant)) {
            throw new Exception('Outside of business hours');
        }

        if ($this->reservationRepository->hasConflict($restaurant->id, $data)) {
            throw new ReservationConflictException('Table already reserved at this time.');
        }

        try {
            return $this->reservationRepository->create($restaurant->id, $data);
        } catch (QueryException $e) {
            throw new CreateReservationException(
                'Error creating table',
                0,
                $e
            );
        }
    }

    public function confirmByToken(string $token): Reservation
    {
        $reservation = $this->reservationRepository->findByToken($token, ['pending']);

        $this->ensureReservationExists($reservation);

        $this->ensureReservationNotExpired($reservation);

        $reservation->confirm();

        return $reservation->load([
            'restaurant',
            'table'
        ]);
    }

    public function cancelByToken(string $token, array $data): void
    {
        $reservation = $this->reservationRepository->findByToken($token, ['pending', 'confirmed']);

        $this->ensureReservationExists($reservation);

        $this->ensureReservationNotExpired($reservation);

        $reservation->cancel($data['reason']);
    }

    private function ensureReservationExists(?Reservation $reservation): void
    {
        if (!$reservation) {
            throw new InvalidTokenException('Invalid reservation token');
        }
    }

    private function ensureReservationNotExpired(Reservation $reservation): void
    {
        if ($reservation->confirmation_expires_at && $reservation->confirmation_expires_at < now()) {
            $reservation->cancel();
            throw new ExpiredTokenException('Reservation token expired');
        }
    }
}
