@extends('layouts.app')

@section('title')
    | Prodotto {{ $product->name }}
@endsection

@section('content')
@section('content')
    <div class="container">

        @include('admin.partials.action-in-page')

        <div class="show-element d-flex">
            <h1 class="name-mobile mb-5 text-capitalize">{{ $product->name }}</h1>
            <div class="img-box me-5">
                @if ($product->img)
                    <img src="{{ asset('storage/' . $product->img) }}" alt="{{ $product->img_original_name }}">
                    <p>{{ $product->img_original }}</p>
                @else
                    <img src="{{ Vite::asset('resources/img/placeholder.png') }}" alt="Placeholder">
                @endif
            </div>

            <div class="info">
                <h3>Prezzo</h3>
                <p>&euro; {{ number_format($product->price, 2, ',') }}</p>

                @if ($product->is_visible)
                    <h3>Visibilità</h3>
                    <p>Prodotto visibile</p>
                @else
                    <h3>Visibilità</h3>
                    <p>Prodotto non visibile</p>
                @endif

                <h3>Descrizione</h3>
                <p>{!! $product->description !!}</p>
            </div>
        </div>
    </div>
@endsection
