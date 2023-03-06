<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('auth.register', compact('categories'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'restaurant_name' => ['required', 'string', 'min:2', 'max:100'],
                'address' => ['required', 'string', 'min:8', 'max:100'],
                'iva' => ['required', 'digits:11', 'unique:restaurants,iva'],
                'telephone' => ['required', 'min:5', 'max:20'],
                'img' => ['nullable', 'image', 'max:3100'],
                'categories' => ['required']
            ],
            [
                //User name
                'name.required' => 'Il nome utente è un campo obbligatorio',
                'name.string' => 'Il nome utente deve essere una stringa',
                'name.max' => 'Il nome utente è consente al massimo :max caratteri',

                //User e-mail
                'email.required' => 'L\'indirizzo e-mail è un campo obbligatorio',
                'email.string' => 'L\'indirizzo e-mail deve essere una stringa',
                'email.email' => 'L\'indirizzo e-mail inserito non è valido',
                'email.max' => 'L\'indirizzo e-mail consente al massimo :max caratteri',
                'email.unique' => 'L\'indirizzo e-mail inserito è già esistente',

                //User password
                'password.required' => 'La password è un campo obbligatorio',
                'password.min' => 'La password richiede almeno 8 caratteri',
                'password.confirmed' => 'Le password non coincidono',


                //Restaurant name
                'restaurant_name.required' => 'Il nome del ristorante è un campo obbligatorio',
                'restaurant_name.min' => 'Il nome del ristorante richiede almeno :min caratteri',
                'restaurant_name.max' => 'Il nome del ristorante consente al massimo :max caratteri',

                //Restaurant address
                'address.required' => 'L\'indirizzo del ristorante è un campo obbligatorio',
                'address.min' => 'L\'indirizzo del ristorante richiede almeno :min caratteri',
                'address.max' => 'L\'indirizzo del ristorante consente al massimo :max caratteri',

                //Restaurant iva
                'iva.required' => 'La partita iva del ristorante è un campo obbligatorio',
                'iva.unique' => 'La partita iva inserita è già esistente',
                'iva.digits' => 'La partita iva del ristorante deve essere composta da 11 cifre',

                //Restaurant telephone
                'telephone.required' => 'Il numero di telefono è un campo obbligatorio',
                'telephone.min' => 'Il numero di telefono richiede almeno :min caratteri',
                'telephone.max' => 'Il numero di telefono consente al massimo :max caratteri',

                //Restaurant image
                'img' => 'Il file caricato non è corretto',
                'img.max' => 'Il campo immagine consente il caricamento di un file al massimo di 3 Mb',

                //Restaurant category
                'categories.required' => 'Selezionare almeno un\'opzione'
            ]
        );

        //User table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        //Restaurant table
        $request['slug'] = Restaurant::generateSlug($request['restaurant_name']);

        if (array_key_exists('img', $request->all())) {
            $request['img_original_name'] = $request->file('img')->getClientOriginalName();
            $request['img'] = Storage::put('uploads', $request['img']);
        }


        $restaurant = Restaurant::create([
            'user_id' => $user->id,
            'name' => $request->restaurant_name,
            'slug' => $request->slug,
            'address' => $request->address,
            'iva' => $request->iva,
            'telephone' => $request->telephone,
            'img' => $request->img,
            'img_original_name' => $request->img_original_name
        ]);


        if(array_key_exists('categories', $request->all())) {
            $restaurant->categories()->attach($request['categories']);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
