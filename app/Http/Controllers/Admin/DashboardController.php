<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->get();
        $restaurant = $restaurants[0];

        return view('admin.restaurants.index', compact('restaurant'));
    }
}
