<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i = 0; $i < 4000; $i++) {
            $new_order = new Order();
            $new_order->name = $faker->firstName();
            $new_order->surname = $faker->lastName();
            $new_order->email = $faker->email();
            $new_order->telephone = $faker->e164PhoneNumber();
            $new_order->restaurant_id = Restaurant::inRandomOrder()->first()->id;
            $new_order->address = $faker->address();
            $new_order->amount = 0;
            $new_order->created_at = $faker->dateTimeBetween('-3 year');
            $new_order->save();
        }
    }
}
