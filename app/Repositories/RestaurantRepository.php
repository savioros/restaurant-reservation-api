<?php

namespace App\Repositories;

use App\Models\Restaurant;

class RestaurantRepository
{
    public function create(int $userId, array $data): Restaurant
    {
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
    }

    public function update(Restaurant $restaurant, array $data): Restaurant
    {
        $restaurant->update($data);
        return $restaurant;
    }

    public function userHasRestaurant(int $userId): bool
    {
        return Restaurant::where('user_id', $userId)->exists();
    }
}
