<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Support\Collection;

class TableRepository
{
    public function create(int $restaurantId, array $data): Table
    {
        return Table::create([
            'restaurant_id' => $restaurantId,
            'number' => $data['number'],
            'capacity' => $data['capacity'],
            'location' => $data['location']
        ]);
    }

    public function getByRestaurant(Restaurant $restaurant): Collection
    {
        return Table::where('restaurant_id', $restaurant->id)->get();
    }
}
