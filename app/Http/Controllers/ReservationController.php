<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateReservationException;
use App\Exceptions\ReservationConflictException;
use App\Exceptions\RestaurantClosedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Services\ReservationService;
use Exception;

class ReservationController extends Controller
{
    public function store(ReservationRequest $request, Restaurant $restaurant, ReservationService $reservationService)
    {
        try {
            $reservation = $reservationService->create($restaurant, $request->validated());
            return new ReservationResource($reservation);
        } catch (CreateReservationException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        } catch (RestaurantClosedException|ReservationConflictException|Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Restaurant $restaurant, Reservation $reservation)
    {
        $reservation = $restaurant->reservations()
            ->findOrFail($reservation->id);

        return new ReservationResource($reservation);
    }
}
