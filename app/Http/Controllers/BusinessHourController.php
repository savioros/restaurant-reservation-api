<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateBusinessHourException;
use App\Exceptions\UserAreProhibitedCreateOrModifyingThirdpartyRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessHourRequest;
use App\Http\Resources\BusinessHourResource;
use App\Models\Restaurant;
use App\Services\RegisterBusinessHourService;

class BusinessHourController extends Controller
{
    public function store(BusinessHourRequest $request, Restaurant $restaurant, RegisterBusinessHourService $service)
    {
        try {
            $businessHour = $service->create(auth()->id(), $restaurant, $request->validated());
            return new BusinessHourResource($businessHour);
        } catch (CreateBusinessHourException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        } catch (UserAreProhibitedCreateOrModifyingThirdpartyRestaurant $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }
}
