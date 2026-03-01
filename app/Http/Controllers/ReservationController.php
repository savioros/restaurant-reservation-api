<?php

namespace App\Http\Controllers;

use App\Events\ReservationConfirmed;
use App\Http\Requests\CancelReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request, Restaurant $restaurant, ReservationService $reservationService)
    {
        $reservation = $reservationService->create($restaurant, $request->validated());
        return new ReservationResource($reservation);
    }

    public function show(Restaurant $restaurant, Reservation $reservation)
    {
        $reservation = $restaurant->reservations()
            ->findOrFail($reservation->id);

        return new ReservationResource($reservation);
    }

    public function confirm(string $token, ReservationService $reservationService)
    {
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
    }

    public function cancel(CancelReservationRequest $request, string $token, ReservationService $reservationService)
    {
        $reservationService->cancelByToken($token, $request->validated());
        return response()->json([
            'message' => 'Reservation cancelled'
        ]);
    }
}
