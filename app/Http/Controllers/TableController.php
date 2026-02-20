<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TableRegisterRequest;
use App\Models\Restaurant;
use App\Services\RegisterTableService;

class TableController extends Controller
{
    public function store(TableRegisterRequest $request, Restaurant $restaurant, RegisterTableService $service)
    {
        try {
            $table = $service->create($restaurant->id, $request->validated());
            return response()->json($table);
        } catch (CreateTableException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
