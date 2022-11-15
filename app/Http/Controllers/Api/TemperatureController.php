<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemperatureRequest;
use App\Http\Resources\TemperatureResource;
use App\Models\Temperature;
use DB;

class TemperatureController extends Controller
{
    public function index(TemperatureRequest $request)
    {
        $temperature = Temperature::with('region')->whereBetween(Temperature::getTableName().".created_at", [
            $request->query('date') . ' 00:00:00', $request->query('date') . ' 23:59:59'
        ])->get();

        if (!count($temperature)) {
            return response()->json([
                "status" => true,
                "message" => "No data for this date",
                'data' => []
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Temperature day list",
            "data" => TemperatureResource::collection($temperature)
        ]);
    }
}
