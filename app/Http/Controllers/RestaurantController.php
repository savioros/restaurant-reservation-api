<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateRestaurantException;
use App\Exceptions\UserAlreadyHasARestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRegisterRequest;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use App\Services\RestaurantService;

class RestaurantController extends Controller
{
    public function index()
    {
        return RestaurantResource::collection(Restaurant::all());    
    }

    public function store(RestaurantRegisterRequest $request, RestaurantService $service)
    {
        try {
            $restaurant = $service->create(auth()->id(), $request->validated());
            return new RestaurantResource($restaurant);
        } catch (CreateRestaurantException|UserAlreadyHasARestaurant $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant);
    }
}
