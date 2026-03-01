<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Restaurant;
use App\Services\TableService;

class TableController extends Controller
{
    public function index(Restaurant $restaurant, TableService $service)
    {
        $tables = $service->getByRestaurant($restaurant);
        return TableResource::collection($tables);
    }

    public function store(StoreTableRequest $request, Restaurant $restaurant, TableService $tableService)
    {
        $table = $tableService->create(auth()->id(), $restaurant, $request->validated());
        return new TableResource($table);
    }
}
