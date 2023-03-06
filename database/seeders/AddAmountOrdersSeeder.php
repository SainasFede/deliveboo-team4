<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddAmountOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            $amount = 0;
            foreach ($order->products as $product) {
                $amount  += $product->price * $product->pivot->quantity;
            }

            $order->amount = $amount;
            $order->update();
        }
    }
}
