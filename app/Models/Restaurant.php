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

    public function Table()
    {
        $this->hasMany(Table::class);
    }

    public function BusinessHour()
    {
        $this->hasMany(BusinessHour::class);
    }
}
