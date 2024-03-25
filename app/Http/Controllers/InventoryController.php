<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Vehicle;
use App\Models\User;

class InventoryController extends Controller
{
    //
    public function getInventory(Request $request){
        //return Inventory::all();
        $user_id = $request->query('userId');
        $inventory = Inventory::join('vehicle', 'vehicle.vehicle_id', '=', 'user_vehicle.vehicle_id')
        ->where('user_id', $user_id)
        ->select('vehicle.vehicle_brand', 'vehicle.vehicle_model', 'vehicle.img_path', 'vehicle.sell_price', 'user_vehicle.item_id', 'vehicle_details') 
        ->get();

        if ($inventory) {
            return response()->json($inventory);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function addInventory(Request $request){
        $user_id = $request->input('userid');
        $vehicleId = $request->input('vehicleId');

        $item = new Inventory;

        $item->vehicle_id = $vehicleId;
        $item->user_id = $user_id;

        $item->save();

        return response()->json(['message' => 'Vehicle purchased successfully', 'vehicle_id' => $vehicleId, 'user_id' => $user_id], 200);
    }
    public function takeInventory(Request $request){

        $itemId = $request['item_id'];

        $item = Inventory::where('item_id', $itemId);

        $item->delete();

        return response()->json(['message' => 'Vehicle sold successfully', 'item_id' => $itemId], 200);
    }

    public function countInventory(Request $request){
        $user_id = $request->query('userId');
        
        $vehiclesSum = Inventory::where('user_id', $user_id)->count();

        if ($vehiclesSum) {
            return response()->json($vehiclesSum);
        } else {
            return response()->json(0);
        }
    }


    
}