<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateRestaurantException;
use App\Exceptions\UpdateRestaurantException;
use App\Exceptions\UserAlreadyHasARestaurantException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use App\Services\RestaurantService;

class RestaurantController extends Controller
{
    public function index()
    {
        return RestaurantResource::collection(Restaurant::all());
    }

    public function store(StoreRestaurantRequest $request, RestaurantService $restaurantService)
    {
        try {
            $restaurant = $restaurantService->create(auth()->id(), $request->validated());
            return new RestaurantResource($restaurant);
        } catch (CreateRestaurantException|UserAlreadyHasARestaurantException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant);
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant, RestaurantService $restaurantService)
    {
        $restaurant = $restaurantService->update(auth()->id(), $restaurant, $request->validated());
        return new RestaurantResource($restaurant);
    }
}
