<?php

namespace App\Services;

use App\Exceptions\CreateTableException;
use App\Models\Table;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RegisterTableService
{
    public function create(int $restaurantId, array $data): Table
    {
        try {
            return DB::transaction(function () use ($restaurantId, $data) {
                return Table::create([
                    'restaurant_id' => $restaurantId,
                    'number' => $data['number'],
                    'capacity' => $data['capacity'],
                    'location' => $data['location']
                ]);
            });
        } catch (QueryException $e) {
            throw new CreateTableException(
                'Error creating table',
                0,
                $e
            );
        }
    }
}
