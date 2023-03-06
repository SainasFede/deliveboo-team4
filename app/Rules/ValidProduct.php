<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class ValidProduct implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $cart = json_decode($value);
        if (!$cart) {
            return false;
        }
        $cart_items = $cart->items;
        $cart_restaurant_id = $cart->restaurant;

        foreach ($cart_items as $item) {
            $product = Product::find($item->product);
            if (!$product || $product->restaurant_id !== $cart_restaurant_id) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
