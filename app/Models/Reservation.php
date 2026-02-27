<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'restaurant_id',
        'table_id',
        'user_id',
        'reservation_date',
        'start_time',
        'end_time',
        'guests_count',
        'status',
        'cancellation_reason',
        'confirmed_at',
        'cancelled_at',
        'completed_at',
        'confirmation_token',
        'confirmation_expires_at',
        'customer_name',
        'customer_email',
        'customer_phone',
    ];

    protected $casts = [
        'status' => ReservationStatus::class,
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cancel(?string $reason = null): void
    {
        $this->update([
            'status' => ReservationStatus::CANCELLED->value,
            'cancellation_reason' => $reason ?? 'The customer did not confirm in time',
            'cancelled_at' => now(),
        ]);
    }

    public function confirm(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }
}
