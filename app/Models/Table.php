<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = [
        'restaurant_id',
        'number',
        'capacity',
        'min_capacity',
        'description',
        'location',
        'active',
    ];

    public function Reservation()
    {
        $this->hasMany(Reservation::class);
    }
}
