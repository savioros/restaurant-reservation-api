<?php

namespace App\Http\Controllers;

use App\Exceptions\CreateTableException;
use App\Exceptions\UserAreProhibitedCreateOrModifyingThirdpartyRestaurant;
use App\Http\Controllers\Controller;
use App\Http\Requests\TableRegisterRequest;
use App\Http\Resources\TableResource;
use App\Models\Restaurant;
use App\Models\Table;
use App\Services\RegisterTableService;

class TableController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $tables = Table::where('restaurant_id', $restaurant->id)->get();
        return TableResource::collection($tables);
    }

    public function store(TableRegisterRequest $request, Restaurant $restaurant, RegisterTableService $service)
    {
        try {
            $table = $service->create(auth()->id(), $restaurant, $request->validated());
            return new TableResource($table);
        } catch (CreateTableException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        } catch (UserAreProhibitedCreateOrModifyingThirdpartyRestaurant $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 403);
        }
    }
}
