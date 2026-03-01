<?php

namespace App\Services;

use App\Exceptions\CreateBusinessHourException;
use App\Exceptions\UserAreProhibitedCreateOrModifyingThirdpartyRestaurantException;
use App\Models\BusinessHour;
use App\Models\Restaurant;
use App\Repositories\BusinessHourRepository;
use Illuminate\Database\QueryException;

class BusinessHourService
{
    public function __construct(
        private BusinessHourRepository $businessHourRepository
    )
    {}

    public function create(int $userId, Restaurant $restaurant, array $data): BusinessHour
    {
        if ($userId != $restaurant->user_id) throw new UserAreProhibitedCreateOrModifyingThirdpartyRestaurantException();

        try {
            return $this->businessHourRepository->create($restaurant->id, $data);
        } catch (QueryException $e) {
            throw new CreateBusinessHourException();
        }
    }
}
