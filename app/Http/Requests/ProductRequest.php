<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:150',
            'price' => 'required|max:999.99',
            'img' => 'nullable|image|max:3200',
            'description' => 'required|max:2000',
            'is_visible' => 'required'
        ];

    }

    public function messages()
    {
        return [

            //name
            'name.required' => 'Il nome del prodotto è un campo obbligatorio',
            'name.min' => 'Il nome del prodotto richiede almeno :min caratteri',
            'name.max' => 'Il nome del prodotto consente al massimo :max caratteri',

            //is_visible
            'is_visible.required' => 'La visibilità è un campo obbligatorio',

            //price
            'price.required' => 'Il prezzo è un campo obbligatorio',
            'price.max' => 'Il prezzo non può superare :max',

            //image
            'img.image' => 'Il file caricato non è corretto',
            'img.max' => 'Il campo immagine consente il caricamento di un file al massimo di 3MB',

            //description
            'description.required' => 'La descrizione è un campo obbligatorio',
            'description.max' => 'La descrizione consente al massimo :max caratteri',
        ];
    }
}
