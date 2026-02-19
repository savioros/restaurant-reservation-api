<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    protected $fillable = [
        'restaurant_id',
        'day_of_week',
        'open_time',
        'close_time',
        'interval_minutes',
        'is_closed',
    ];
}
