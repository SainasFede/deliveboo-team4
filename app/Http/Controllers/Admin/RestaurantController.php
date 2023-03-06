<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Requests\RestaurantRequest;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $restaurant = $user->restaurants[0];

        return view('admin.restaurants.index', compact('restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        if ($restaurant->user_id === Auth::id()) {
            $categories = Category::all();
            return view('admin.restaurants.edit', compact('restaurant', 'categories'));
        } else {
            return (abort(404));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        if ($restaurant->user_id !== Auth::id()) {
            return (abort(404));
        } else {

            $request->validate(
                [
                    'name' => ['required', 'string', 'min:2', 'max:100'],
                    'address' => ['required', 'string', 'min:8', 'max:100'],
                    'iva' => ['required', 'digits:11', 'unique:restaurants,iva,' . $restaurant->id],
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
                    'password.confirmed' => 'La password non corrisponde a quella inserito',

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
                    'img.image' => 'Il file caricato non è corretto',
                    'img.max' => 'Il campo immagine consente il caricamento di un file al massimo di 3MB',

                    //Restaurant category
                    'categories.required' => 'Selezionare almeno una categoria'
                ]
            );

            $form_data = $request->all();

            if ($form_data['name'] != $restaurant->name) {
                $form_data['slug'] = Restaurant::generateSlug(($form_data['name']));
            } else {
                $form_data['slug'] = $restaurant->slug;
            }

            if (array_key_exists('img', $form_data)) {
                if ($restaurant->img) {
                    Storage::disk('public')->delete($restaurant->img);
                }

                $form_data['img_original_name'] = $request->file('img')->getClientOriginalName();
                $form_data['img'] = Storage::put('uploads', $form_data['img']);
            }

            $restaurant->update($form_data);

            if(array_key_exists('categories', $form_data)) {
                $restaurant->categories()->sync($form_data['categories']);
            }else {
                $restaurant->categories()->detach();
            }

            return redirect()->route('admin.restaurants.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
