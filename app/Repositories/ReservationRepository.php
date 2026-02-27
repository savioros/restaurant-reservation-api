<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Support\Str;

class ReservationRepository
{
    public function create(int $restaurantId, array $data): Reservation
    {
        return Reservation::create([
            'restaurant_id' => $restaurantId,
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
    }

    public function hasConflict(int $restaurantId, array $data): bool
    {
        return Reservation::where('restaurant_id', $restaurantId)
            ->where('table_id', $data['table_id'])
            ->where('reservation_date', $data['reservation_date'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();
    }

    public function findByToken(string $token, array $status = []): ?Reservation
    {
        return Reservation::where('confirmation_token', $token)
            ->when($status, fn ($query) => $query->whereIn('status', $status))
            ->first();
    }
}
