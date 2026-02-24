<?php

namespace App\Services;

use App\Exceptions\CreateReservationException;
use App\Models\BusinessHour;
use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Database\QueryException;

class RegisterReservationService
{
    public function create(Restaurant $restaurant, array $data): Reservation
    {
        try {
            return Reservation::create([
                'restaurant_id' => $restaurant->id,
                'table_id' => $data['table_id'],
                'reservation_date' => $data['reservation_date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['start_time'],
                'guests_count' => $data['guests_count'],
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone']
            ]);
        } catch (QueryException $e) {
            throw new CreateReservationException(
                'Error creating table',
                0,
                $e
            );
        }
    }
}
