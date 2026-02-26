<?php

namespace App\Http\Controllers;

use App\Events\ReservationConfirmed;
use App\Exceptions\CreateReservationException;
use App\Exceptions\ExpiredTokenException;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\ReservationConflictException;
use App\Exceptions\RestaurantClosedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancelReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Services\ReservationService;
use Exception;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request, Restaurant $restaurant, ReservationService $reservationService)
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

    public function confirm(string $token, ReservationService $reservationService)
    {
        try {
            $reservation = $reservationService->confirmByToken($token);

            ReservationConfirmed::dispatch(
                $reservation->customer_name,
                $reservation->reservation_date,
                $reservation->start_time,
                $reservation->end_time,
                $reservation->restaurant()->first()->name,
                $reservation->table()->first()->number,
                $reservation->guests_count,
                $reservation->customer_email
            );

            return response()->json([
                'message' => 'Reservation confirmed'
            ]);
        } catch (InvalidTokenException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch (ExpiredTokenException) {
            return response()->json([
                'message' => 'Token has expired'
            ], 410);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error confirming reservation'
            ], 500);
        }
    }

    public function cancel(CancelReservationRequest $request, string $token, ReservationService $reservationService)
    {
        try {
            $reservationService->cancelByToken($token, $request->validated());

            return response()->json([
                'message' => 'Reservation cancelled'
            ]);
        } catch (InvalidTokenException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch (ExpiredTokenException) {
            return response()->json([
                'message' => 'Token has expired'
            ], 410);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error cancelling reservation'
            ], 500);
        }
    }
}
