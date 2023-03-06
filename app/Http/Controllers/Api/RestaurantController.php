<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        $categories = Category::all();

        return response()->json(compact('restaurants', 'categories'));
    }

    public function show($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->with(['categories'])->first();

        if ($restaurant) {
            $products = Product::where('restaurant_id', $restaurant->id)->get();
            return response()->json([
                'restaurant' => $restaurant,
                'products' => $products,
                'success' => true
            ]);  /* compact('restaurant', 'products') */
        } else {
            return response()->json([
                'success' => false,
            ], 404);
        }
    }

    public function search()
    {
        $searched = $_GET['searched'];
        $restaurants = Restaurant::where('name', 'like', "%$searched%")->with('categories')->get();

        return response()->json(compact('restaurants'));
    }

    public function getByCategory($values)
    {
        $categoryChoice = explode(',', $values);
        $restaurants = Restaurant::with('categories')->whereHas('categories', function (Builder $query) use ($categoryChoice) {
            $query->whereIn('category_id', $categoryChoice)
                ->groupBy('restaurant_id')
                ->select('restaurant_id')
                ->havingRaw('COUNT(DISTINCT category_id) = ' . count($categoryChoice));
        })->get();

        return response()->json(compact('restaurants'));
    }

    public function getTeamMembers()
    {
        $team_members = TeamMember::all();

        return response()->json(compact('team_members'));
    }
}
