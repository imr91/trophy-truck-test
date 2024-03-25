<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\InventoryController;

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/getUser', [UserController::class, 'index']);
Route::get('/getUserList', [UserController::class, 'getUsers']);
Route::get('/getVehicles', [VehicleController::class, 'vehicleList']);
Route::get('/getBrands', [VehicleController::class, 'brandList']);
Route::get('/getInventory', [InventoryController::class, 'getInventory']);
Route::post('/buyVehicle', [InventoryController::class, 'addInventory']);
Route::post('/sellVehicle', [InventoryController::class, 'takeInventory']);
Route::get('/countVehicle', [InventoryController::class, 'countInventory']);
Route::post('/subBalance', [UserController::class, 'balanceDown']);
Route::post('/addBalance', [UserController::class, 'balanceUp']);