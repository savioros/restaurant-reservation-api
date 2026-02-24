<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Restaurant;
use App\Services\RegisterReservationService;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request, Restaurant $restaurant, RegisterReservationService $service)
    {
        $reservation = $service->create($restaurant, $request->validated());
        return new ReservationResource($reservation);
    }
}
