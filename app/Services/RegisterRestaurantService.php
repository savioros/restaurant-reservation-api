<?php

namespace App\Services;

use App\Exceptions\CreateRestaurantException;
use App\Exceptions\UserAlreadyHasARestaurant;
use App\Models\Restaurant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class RegisterRestaurantService
{
    public function create(int $userId, array $data): Restaurant
    {
        $userHasRestaurant = Restaurant::where('user_id', $userId)->exists();

        if ($userHasRestaurant) {
            throw new UserAlreadyHasARestaurant('User already has a restaurant');
        }
        
        try {
            return Restaurant::create([
                'user_id' => $userId,
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip_code' => $data['zip_code']
            ]);
        } catch (QueryException $e) {
            throw new CreateRestaurantException(
                'Error creating restaurant',
                0,
                $e
            );
        }
    }
}
