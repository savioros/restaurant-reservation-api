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
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class ReservationService
{
    public function create(Restaurant $restaurant, array $data): Reservation
    {
        $date = Carbon::parse($data['reservation_date']);

        if ($date->isPast() && !$date->isToday()) {
            throw new Exception('You cannot book on past dates.');
        }

        $businessHour = BusinessHour::where('restaurant_id', $restaurant->id)
            ->where('day_of_week', $date->dayOfWeek)
            ->first();

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

        $conflict = Reservation::where('restaurant_id', $restaurant->id)
            ->where('table_id', $data['table_id'])
            ->where('reservation_date', $data['reservation_date'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($conflict) {
            throw new ReservationConflictException('Table already reserved at this time.');
        }

        try {
            return Reservation::create([
                'restaurant_id' => $restaurant->id,
                'table_id' => $data['table_id'],
                'reservation_date' => $data['reservation_date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'guests_count' => $data['guests_count'],
                'status' => 'pending',
                'confirmation_token' => Str::random(32),
                'confirmation_expires_at' => now()->addMinutes(30),
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
            ]);
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
        $reservation = Reservation::where('confirmation_token', $token)
            ->where('status', 'pending')
            ->first();

        if (!$reservation) {
            throw new InvalidTokenException('Invalid reservation token');
        }

        if ($reservation->confirmation_expires_at && $reservation->confirmation_expires_at < now()) {
            $reservation->update(['status' => 'cancelled']);
            throw new ExpiredTokenException('Reservation token expired');
        }

        $reservation->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return $reservation->load([
            'restaurant',
            'table'
        ])->first();
    }

    public function cancelByToken(string $token, array $data): void
    {
        $reservation = Reservation::where('confirmation_token', $token)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if (!$reservation) {
            throw new InvalidTokenException('Invalid reservation token');
        }

        if ($reservation->confirmation_expires_at && $reservation->confirmation_expires_at < now()) {
            $reservation->update(['status' => 'cancelled']);
            throw new ExpiredTokenException('Reservation token expired');
        }

        $reservation->update([
            'status' => 'cancelled',
            'cancellation_reason' => $data['reason'],
            'cancelled_at' => now(),
        ]);
    }
}
