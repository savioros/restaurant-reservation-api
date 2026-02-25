<?php

namespace App\Services;

use App\Exceptions\CreateTableException;
use App\Exceptions\UserAreProhibitedCreateOrModifyingThirdpartyRestaurant;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Database\QueryException;

class TableService
{
    public function create(int $userId, Restaurant $restaurant, array $data): Table
    {
        if ($userId != $restaurant->user_id) throw new UserAreProhibitedCreateOrModifyingThirdpartyRestaurant('You do not have permission to create or modify this restaurant\'s information');

        try {
            return Table::create([
                'restaurant_id' => $restaurant->id,
                'number' => $data['number'],
                'capacity' => $data['capacity'],
                'location' => $data['location']
            ]);
        } catch (QueryException $e) {
            throw new CreateTableException(
                'Error creating table',
                0,
                $e
            );
        }
    }
}
