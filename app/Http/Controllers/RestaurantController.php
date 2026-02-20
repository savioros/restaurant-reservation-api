<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateRestaurantException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRegisterRequest;
use App\Services\RegisterRestaurantService;

class RestaurantController extends Controller
{
    public function store(RestaurantRegisterRequest $request, RegisterRestaurantService $service)
    {
        try {
            $restaurant = $service->create($request->validated());
            return response()->json($restaurant);
        } catch (CreateRestaurantException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
