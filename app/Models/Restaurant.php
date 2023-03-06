<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'address',
        'iva',
        'telephone',
        'img',
        'img_original_name',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function user() {
        return $this->belongsTo(Restaurant::class);
    }

    public static function generateSlug($string)
    {
        $slug = Str::slug($string, '-');
        $original_slug = $slug;
        $c = 1;
        $exist = Restaurant::where('slug', $slug)->first();

        while ($exist) {
            $slug = $original_slug . '-' . $c;
            $exist = Restaurant::where('slug', $slug)->first();
            $c++;
        }
        return $slug;
    }
}
