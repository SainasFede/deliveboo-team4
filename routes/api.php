<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('Api')
    ->prefix('restaurants')
    ->group(function () {
        Route::get('/', [RestaurantController::class, 'index']);
        Route::get('/search', [RestaurantController::class, 'search']);
        Route::get('/team_members', [RestaurantController::class, 'getTeamMembers']);
        Route::get('/{slug}', [RestaurantController::class, 'show']);
        Route::get('/restaurantsbycategory/{values}', [RestaurantController::class, 'getByCategory']);
    });

Route::get('orders/generate', [OrderController::class, 'generate']);
Route::post('orders/make/payment', [OrderController::class, 'makePayment']);
