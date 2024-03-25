<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    //
    public function vehicleList(Request $request)
    {
        //return Vehicle::all();
        $brand = $request->input('brand');
        $type = $request->input('type');
        $cost = $request->input('cost');

        $vehicles = Vehicle::select('*');

        if ($brand != 'all') {
            $vehicles->where('vehicle_brand', $brand);
        }

        if ($type != '-') {
            $vehicles->where('vehicle_details', 'LIKE', "%$type%");
        }

        if ($cost != '-') {
            if ($cost == 'high') {
                $vehicles->orderBy('price', 'desc');
            } elseif ($cost == 'low') {
                $vehicles->orderBy('price', 'asc');
            }
        }

        $vehicles = $vehicles->get();

        //$sqlQuery = $vehicles->toSql();
        //echo $sqlQuery;

        if ($vehicles) {
            return response()->json($vehicles);
        } else {
            return response()->json(['message' => 'Error in query'], 404);
        }
    }

    public function brandList()
    {
        $list = Vehicle::select('vehicle_brand')->distinct()->get();
        if ($list) {
            return response()->json($list);
        } else {
            return response()->json(['message' => 'Error in query'], 404);
        }
    }
}
