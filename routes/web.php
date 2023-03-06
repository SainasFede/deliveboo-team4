<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('statistics', [StatisticController::class, 'index'])->name('statistics');
        Route::get('statistics/show/year/{year}', [StatisticController::class, 'showByYear'])->name('statisticsByYear');
        Route::resource('products', ProductController::class);
        Route::resource('restaurants', RestaurantController::class)->except('store', 'create', 'show', 'destroy');
        Route::resource('orders', OrderController::class)->except('create', 'edit', 'update', 'destroy');
    });


require __DIR__ . '/auth.php';

Route::get('{any?}', function () {
    return view('guest.home');
})->where('any', '.*')->name('home');
