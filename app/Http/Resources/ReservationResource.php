<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reservation_date' => $this->reservation_date,
            'start_time' => $this->start_time,
            'guests_count' => $this->guests_count,
            'status' => 'confirmed'
        ];
    }
}
