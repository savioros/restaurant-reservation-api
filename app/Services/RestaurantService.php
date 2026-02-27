<?php

namespace App\Services;

use App\Exceptions\CreateRestaurantException;
use App\Exceptions\UserAlreadyHasARestaurant;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Database\QueryException;

class RestaurantService
{
    public function __construct(
        private RestaurantRepository $restaurantRepository
    )
    {}

    public function create(int $userId, array $data): Restaurant
    {
        $userHasRestaurant = $this->restaurantRepository->userHasRestaurant($userId);

        if ($userHasRestaurant) {
            throw new UserAlreadyHasARestaurant('User already has a restaurant');
        }

        try {
            return $this->restaurantRepository->create($userId, $data);
        } catch (QueryException $e) {
            throw new CreateRestaurantException(
                'Error creating restaurant',
                0,
                $e
            );
        }
    }
}
