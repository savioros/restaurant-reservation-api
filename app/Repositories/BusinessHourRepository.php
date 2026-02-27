<?php

namespace App\Repositories;

use App\Models\BusinessHour;

class BusinessHourRepository
{
    public function create(int $restaurantId, array $data): BusinessHour
    {
        return BusinessHour::create([
            'restaurant_id' => $restaurantId,
            'day_of_week' => $data['day_of_week'],
            'open_time' => $data['open_time'],
            'close_time' => $data['close_time'],
            'interval_minutes' => $data['interval_minutes']
        ]);
    }

    public function findByDayOfWeek(int $restaurantId, int $dayOfWeek): ?BusinessHour
    {
        return BusinessHour::where('restaurant_id', $restaurantId)
            ->where('day_of_week', $dayOfWeek)
            ->first();
    }
}
