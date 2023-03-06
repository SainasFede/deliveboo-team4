@extends('layouts.app')

@section('title')
    | Ordini
@endsection

@section('content')
    <div class="container">
        <h1 class="my-5">Ordini</h1>
        <table class="table responsive-table-pc table-striped">
            <thead>
                <tr>
                    <th scope="col">ID Ordine</th>
                    <th scope="col">Cognome e Nome</th>
                    <th scope="col">Numero prodotti</th>
                    <th scope="col">Totale</th>
                    <th scope="col">Data e Ora</th>
                    <th scope="col">Mostra</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->name }} {{ $order->surname }}</td>
                        <td>
                            @php
                                $total_quantity = 0;
                            @endphp
                            @foreach ($order->products as $product)
                                @php
                                    $total_quantity += $product->pivot->quantity;
                                @endphp
                            @endforeach
                            {{ $total_quantity }}
                        </td>
                        <td>&euro; {{ number_format($order->amount, 2, ',') }}</td>
                        <td>{{ date_format($order->created_at, 'd/m/Y - H:i') }}
                        </td>
                        <td>
                            <a class="btn btn-outline-dark" href="{{ route('admin.orders.show', $order) }}"><i
                                    class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nessun ordine presente</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="smartphone-cards">
            @forelse ($orders as $order)
                <div class="card mb-4">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        {{ $order->name }} {{ $order->surname }}
                        <a class="btn btn-outline-dark" title="Mostra" href="{{ route('admin.orders.show', $order) }}"><i
                                class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>ID Ordine</strong>{{ $order->id }}
                        </li>
                        <li class="list-group-item d-flex justify-content-between"> @php
                            $total_quantity = 0;
                        @endphp
                            @foreach ($order->products as $product)
                                @php
                                    $total_quantity += $product->pivot->quantity;
                                @endphp
                            @endforeach
                            <strong>Numero prodotti</strong>{{ $total_quantity }}
                        </li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Totale</strong>&euro;
                            {{ number_format($order->amount, 2, ',') }}
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Data e ora</strong>
                            {{ date_format($order->created_at, 'd/m/Y') }} -
                            {{ date_format($order->created_at, 'H:i') }}
                        </li>

                    </ul>
                </div>
            @empty
                <p>Nessun ordine presente</p>
            @endforelse
        </div>
        <div class="pag-box d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
