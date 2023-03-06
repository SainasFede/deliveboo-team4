@extends('layouts.app')

@section('title')
    | Ristorante {{ $restaurant->name }}
@endsection

@section('content')
    <div class="container">

        <div class="row">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center my-5">
                    <h1 class="text-capitalize">{{ $restaurant->name }}</h1>
                    <a href="{{ route('admin.restaurants.edit', $restaurant) }}" title="Modifica"
                        class="btn btn-outline-dark me-3">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </div>
                <div class="show-element d-flex">

                    <div class="img-box me-5">
                        @if ($restaurant->img)
                            <img src="{{ asset('storage/' . $restaurant->img) }}"
                                alt="{{ $restaurant->img_original_name }}">
                            <p>{{ $restaurant->img_original }}</p>
                        @else
                            <img src="{{ Vite::asset('resources/img/placeholder.png') }}" alt="Placeholder">
                        @endif
                    </div>

                    <div class="info">
                        <h3>Indirizzo</h3>
                        <p>{{ $restaurant->address }}</p>
                        <h3>Telefono</h3>
                        <p>{{ $restaurant->telephone }}</p>
                        <h3>Partita IVA</h3>
                        <p>{{ $restaurant->iva }}</p>

                        <h3>Categorie</h3>
                        @foreach ($restaurant->categories as $category)
                            <span class="badge text-bg-secondary fs-6 mb-2">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
