<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Mail\NewOrderCustomer;
use App\Mail\NewOrderRestaurant;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function generate(Request $request, Gateway $gateway)
    {
        $token = $gateway->clientToken()->generate();

        $data = [
            'success' => true,
            'token' => $token
        ];

        return response()->json($data, 200);
    }

    public function makePayment(OrderRequest $request, Gateway $gateway)
    {

        $data = $request->all();
        $validator = Validator::make(
            $data,
            [
                'name' => 'required|min:2|max:50',
                'surname' => 'required|min:2|max:70',
                'email' => 'required|email|max:255',
                'address' => 'required|min:8|max:100',
                'telephone' => 'required|min:8|max:20',
                'note' => 'max:500',
            ],
            [
                'name.required' => 'Il nome è un campo obbligatorio',
                'name.min' => 'Il nome deve avere al minimo :min caratteri',
                'name.max' => 'Il nome deve avere al massimo :max caratteri',
                'email.required' => 'L\'email è un campo obbligatorio',
                'email.email' => 'L\'email non è formattata correttamente',
                'email.max' => 'L\'email deve avere al massimo :max caratteri',
                'address.required' => 'L\'indirizzo è un campo obbligatorio',
                'address.min' => 'L\'indirizzo deve avere al minimo :min caratteri',
                'address.max' => 'L\'indirizzo deve avere al massimo :max caratteri',
                'telephone.required' => 'Il numero di telefono è un campo obbligatorio',
                'telephone.min' => 'Il numero di telefono richiede almeno :min caratteri',
                'telephone.max' => 'Il numero di telefono consente al massimo :max caratteri',
                'note.max' => 'Il campo note consente al massimo :max caratteri'
            ]
        );

        if ($validator->fails()) {
            $data = [
                'status' => 'errorValidation',
                'errors' => $validator->errors()
            ];

            return response()->json($data, 400);
        }

        $cart = json_decode($request->cart);
        $nonce = $request->payment_method_nonce;
        $amount = 0;
        $cart_items = $cart->items;
        foreach ($cart_items as $item) {
            $product = Product::find($item->product);
            $amount += $product->price * $item->quantity;
        }

        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $data = [
                'status' => 'success',
                'cart' => $cart,
                'amount' => $amount,
                'message' => "Transazione eseguita con Successo!"
            ];

            $order = Order::create([
                'restaurant_id' => $cart->restaurant,
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'address' => $request->address,
                'telephone' => $request->telephone,
                'note' => $request->note,
                'amount' => $amount,
            ]);


            foreach ($cart_items as $item) {
                $product = Product::find($item->product);
                $order->products()->attach($product->id, ['quantity' => $item->quantity]);
            }

            $restaurant = Restaurant::where('id', $order->restaurant_id )->first();
            $user = User::where('id', $restaurant->user_id )->first();
            Mail::to($user->email)->send(new NewOrderRestaurant($order));
            Mail::to($order->email)->send(new NewOrderCustomer ($order));

            return response()->json($data, 200);

        } else {
            $data = [
                'status' => 'errorTransaction',
                'message' => "Transazione Fallita!"
            ];
            return response()->json($data, 401);
        }
    }
}

//CREDIT CARD
// 5555555555554444
