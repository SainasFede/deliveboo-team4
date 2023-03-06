<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr_categories = config('categories.categories');

        foreach ($arr_categories as $category) {
            $new_category = new Category();
            $new_category->name = $category['name'];
            $new_category->slug = Category::generateSlug($new_category->name);
            $new_category->img = $category['img'];
            $new_category->img_original_name = str_replace('uploads/', '', $category['img']);

            $new_category->save();
        }
    }
}
