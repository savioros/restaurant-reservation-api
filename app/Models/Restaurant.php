<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'zip_code',
        'default_duration_minutes',
        'min_advance_hours',
        'max_advance_hours',
        'cancellation_hours',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function businessHours()
    {
        return $this->hasMany(BusinessHour::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
