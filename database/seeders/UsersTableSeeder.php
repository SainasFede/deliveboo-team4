<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $arr_restaurants = config('restaurants.restaurants');

        foreach ($arr_restaurants as $restaurant) {
            $new_user = new User();
            $new_user->name = $faker->name();
            $new_user->email = $restaurant['email'];
            $new_user->email_verified_at = now();
            $new_user->remember_token = Str::random(10);
            $new_user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password;
            $new_user->save();
        }
    }
}
