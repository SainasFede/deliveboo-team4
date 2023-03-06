<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesRestaurantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurants = Restaurant::all();
        $arr_restaurants = config('restaurants.restaurants');

        for ($i = 0; $i < count($restaurants); $i++) {
            $restaurants[$i]->categories()->attach($arr_restaurants[$i]['categories']);
        }
    }
}
