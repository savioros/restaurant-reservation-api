<?php

namespace App\Models;

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
    ];
}
