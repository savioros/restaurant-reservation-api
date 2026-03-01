<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateBusinessHourException;
use App\Exceptions\UserAreProhibitedCreateOrModifyingThirdpartyRestaurantException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessHourRequest;
use App\Http\Resources\BusinessHourResource;
use App\Models\Restaurant;
use App\Services\BusinessHourService;

class BusinessHourController extends Controller
{
    public function store(StoreBusinessHourRequest $request, Restaurant $restaurant, BusinessHourService $businessHourService)
    {
        $businessHour = $businessHourService->create(auth()->id(), $restaurant, $request->validated());
        return new BusinessHourResource($businessHour);
    }
}
