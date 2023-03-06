<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            RestaurantsTableSeeder::class,
            CategoriesTableSeeder::class,
            CategoriesRestaurantsSeeder::class,
            ProductsTableSeeder::class,
            OrdersTableSeeder::class,
            OrdersProductsSeeder::class,
            AddAmountOrdersSeeder::class,
            TeamMembersSeeder::class
        ]);
    }
}
