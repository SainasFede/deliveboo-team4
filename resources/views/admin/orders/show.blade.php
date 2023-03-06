@extends('layouts.app')

@section('title')
    | show order #{{ $order->id }}
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-dark my-3"><i
                class="fa-solid fa-arrow-left"></i></a>
        <div class="card">
            <div class="card-header">
                <h4>Ordine #{{ $order->id }}</h4>
            </div>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><b>Nome e Cognome:</b></span>
                    <span class="ms-3">{{ $order->name }} {{ $order->surname }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><b>Indirizzo:</b></span>
                    <span class="ms-3">{{ $order->address }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><b>Telefono:</b></span>
                    <span class="ms-3">{{ $order->telephone }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><b>Data e ora:</b></span>
                    <span>{{ date_format($order->created_at, 'd/m/Y - H:i') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><b>Note:</b></span>
                    @if ($order->note)
                        <span class="ms-3">
                            {{ $order->note }}
                        </span>
                    @else
                        <span class="ms-3">
                            Non sono presenti note...
                        </span>
                    @endif
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID Prodotto</th>
                                <th scope="col">Nome Prodotto</th>
                                <th scope="col">Prezzo Unitario</th>
                                <th scope="col" class="text-end">Quantità</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ $product->pivot->product_id }}</td>
                                    <td class="text-capitalize">{{ $product->name }}</td>
                                    <td>&euro; {{ number_format($product->price, 2, ',') }}</td>
                                    <td class="text-end">{{ $product->pivot->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <h3><b>Totale:</b></h3>
                    <h3><b>&euro; {{ number_format($order->amount, 2, ',') }}</b></h3>
                </li>

            </ul>

        </div>
    </div>
@endsection
