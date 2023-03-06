<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }

    public static function generateSlug($string)
    {
        $slug = Str::slug($string, '-');
        $original_slug = $slug;
        $c = 1;
        $exist = Category::where('slug', $slug)->first();

        while ($exist) {
            $slug = $original_slug . '-' . $c;
            $exist = Category::where('slug', $slug)->first();
            $c++;
        }
        return $slug;
    }
}
