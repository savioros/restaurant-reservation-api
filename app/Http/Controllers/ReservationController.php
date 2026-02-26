<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateReservationException;
use App\Exceptions\ReservationConflictException;
use App\Exceptions\RestaurantClosedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Mail\ReservationCreateMail;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Services\ReservationService;
use Exception;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function store(StoreReservationRequest $request, Restaurant $restaurant, ReservationService $reservationService)
    {
        try {
            $reservation = $reservationService->create($restaurant, $request->validated());

            $mail = new ReservationCreateMail(
                $request->customer_name,
                $reservation->reservation_date,
                $reservation->start_time,
                $reservation->end_time,
                $restaurant->name,
                1,
                $reservation->guests_count,
                '/',
                '/'
            );

            Mail::to($request->customer_email)->send($mail);

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
