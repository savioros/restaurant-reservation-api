<?php

namespace App\Services;

use App\Exceptions\CreateRestaurantException;
use App\Exceptions\RestaurantDoesNotBelongToUserException;
use App\Exceptions\UpdateRestaurantException;
use App\Exceptions\UserAlreadyHasARestaurantException;
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

        if ($userHasRestaurant) throw new UserAlreadyHasARestaurantException();

        try {
            return $this->restaurantRepository->create($userId, $data);
        } catch (QueryException $e) {
            throw new CreateRestaurantException();
        }
    }

    public function update(int $userId, Restaurant $restaurant, array $data): Restaurant
    {
        if ($restaurant->user_id !== $userId) throw new RestaurantDoesNotBelongToUserException();

        try {
            return $this->restaurantRepository->update($restaurant, $data);
        } catch (QueryException $e) {
            throw new UpdateRestaurantException();
        }
    }
}
