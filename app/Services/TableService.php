<?php

namespace App\Services;

use App\Exceptions\CreateTableException;
use App\Exceptions\UserAreProhibitedCreateOrModifyingThirdpartyRestaurant;
use App\Models\Restaurant;
use App\Models\Table;
use App\Repositories\TableRepository;
use Illuminate\Database\QueryException;

class TableService
{
    public function __construct(
        private TableRepository $tableRepository
    )
    {}

    public function create(int $userId, Restaurant $restaurant, array $data): Table
    {
        if ($userId != $restaurant->user_id) throw new UserAreProhibitedCreateOrModifyingThirdpartyRestaurant('You do not have permission to create or modify this restaurant\'s information');

        try {
            return $this->tableRepository->create($restaurant->id, $data);
        } catch (QueryException $e) {
            throw new CreateTableException(
                'Error creating table',
                0,
                $e
            );
        }
    }

    public function getByRestaurant(Restaurant $restaurant): Collection {
        return $this->tableRepository->getByRestaurant($restaurant);
    }
}
