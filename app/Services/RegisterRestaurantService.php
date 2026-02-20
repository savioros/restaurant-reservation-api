<?php

namespace App\Services;

use App\Exceptions\CreateRestaurantException;
use App\Models\Restaurant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RegisterRestaurantService
{
    public function create(array $data): Restaurant
    {
        try {
            return DB::transaction(function () use ($data) {
                return Restaurant::create([
                    'user_id' => auth()->user()->id,
                    'name' => $data['name'],
                    'slug' => $data['name'],
                    'description' => $data['description'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'zip_code' => $data['zip_code']
                ]);
            });
        } catch (QueryException $e) {
            throw new CreateRestaurantException(
                'Error creating restaurant',
                0,
                $e
            );
        }
    }
}
