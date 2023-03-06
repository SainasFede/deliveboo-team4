<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *@return void
     */
    public function run()
    {
        $arr_restaurants = config('restaurants.restaurants');

        $c = 1;
        foreach ($arr_restaurants as $restaurant) {
            $new_restaurant = new Restaurant();
            $new_restaurant->user_id = $c;
            $new_restaurant->name = $restaurant['name'];
            $new_restaurant->slug = Restaurant::generateSlug($new_restaurant->name);
            $new_restaurant->address = $restaurant['address'];
            $new_restaurant->iva = $restaurant['iva'];
            $new_restaurant->telephone = $restaurant['telephone'];
            $new_restaurant->img = $restaurant['img'];
            $new_restaurant->img_original_name = str_replace('uploads/', '', $restaurant['img']);

            $new_restaurant->save();

            $c++;
        }
    }
}
