<?php

namespace App\Services;

use App\Exceptions\CreateBusinessHourException;
use App\Exceptions\UserAreProhibitedCreateOrModifyingThirdpartyRestaurant;
use App\Models\BusinessHour;
use App\Models\Restaurant;
use Illuminate\Database\QueryException;

class RegisterBusinessHourService
{
    public function create(int $userId, Restaurant $restaurant, array $data): BusinessHour
    {
        if ($userId != $restaurant->user_id) throw new UserAreProhibitedCreateOrModifyingThirdpartyRestaurant('You do not have permission to create or modify this restaurant\'s information');

        try {
            return BusinessHour::create([
                'restaurant_id' => $restaurant->id,
                'day_of_week' => $data['day_of_week'],
                'open_time' => $data['open_time'],
                'close_time' => $data['close_time'],
                'interval_minutes' => $data['interval_minutes']
            ]);
        } catch (QueryException $e) {
            throw new CreateBusinessHourException(
                'Error creating table',
                0,
                $e
            );
        }
    }
}
