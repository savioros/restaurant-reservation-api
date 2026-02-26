<?php

namespace App\Listeners;

use App\Mail\ReservationConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\ReservationConfirmed;

class SendReservationEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReservationConfirmed $event): void
    {
        $mail = new ReservationConfirmationMail(
            $event->customer_name,
            $event->reservation_date,
            $event->start_time,
            $event->end_time,
            $event->restaurant,
            $event->table,
            $event->guests_count
        );

        Mail::to($event->customer_email)->send($mail);
    }
}
