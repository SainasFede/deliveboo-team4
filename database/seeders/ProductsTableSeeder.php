<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = config('products.products');
        foreach ($products as $product) {
            $new_product = new Product();
            $new_product->restaurant_id = $product['restaurant_id'];
            $new_product->name = $product['name'];
            $new_product->slug = Product::generateSlug($new_product->name);
            $new_product->is_visible = $product['isVisible'];
            $new_product->description = $product['description'];
            $new_product->price = $product['price'];
            $new_product->img = $product['img'];
            $new_product->img_original_name = str_replace('uploads/', '', $product['img']);

            $new_product->save();
        }
    }
}
