<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateReservationException;
use App\Exceptions\ExpiredTokenException;
use App\Exceptions\InvalidTokenException;
use App\Exceptions\ReservationConflictException;
use App\Exceptions\RestaurantClosedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Mail\ReservationConfirmationMail;
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

            $mail = new ReservationConfirmationMail(
                $reservation->customer_name,
                $reservation->reservation_date,
                $reservation->start_time,
                $reservation->end_time,
                $reservation->restaurant()->first()->name,
                $reservation->table()->first()->number,
                $reservation->guests_count,
                '/',
                '/'
            );

            Mail::to($reservation->customer_email)->send($mail);

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
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
