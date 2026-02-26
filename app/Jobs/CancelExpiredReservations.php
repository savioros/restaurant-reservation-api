<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CancelExpiredReservations implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Reservation::where('status', 'pending')
            ->where('confirmation_expires_at', '<', now())
            ->get()
            ->each(fn ($reservation) => $reservation->cancel());
    }
}
