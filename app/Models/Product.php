<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'slug',
        'img',
        'description',
        'img_original_name',
        'restaurant_id',
        'category_id',
        'is_visible'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity')->withTimestamps();
    }

    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class);
    // }

    public static function generateSlug($string)
    {
        $slug = Str::slug($string, '-');
        $original_slug = $slug;
        $c = 1;
        $exist = Product::where('slug', $slug)->first();

        while ($exist) {
            $slug = $original_slug . '-' . $c;
            $exist = Product::where('slug', $slug)->first();
            $c++;
        }
        return $slug;
    }
}
