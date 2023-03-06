@extends('layouts.app')

@section('title')
    | Prodotti
@endsection

@section('content')
    <div class="container">

        <div class="d-flex align-items-center justify-content-between">
            <h1 class="my-5">Prodotti</h1>
            <a href="{{ route('admin.products.create') }}" title="Crea" class="btn btn-outline-dark"><i
                    class="fa-solid fa-plus"></i>
            </a>
        </div>

        <table class="table responsive-table-pc table-striped">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Visibilità</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="text-capitalize">{{ $product->name }}</td>
                        <td>&euro; {{ number_format($product->price, 2, ',') }}</td>
                        <td>
                            @if ($product->is_visible)
                                <i class="fa-solid fa-circle-check"></i> Visibile
                            @else
                                <i class="fa-solid fa-circle-xmark"></i> Non visibile
                            @endif
                        </td>
                        <td>
                            <div class="actions-index d-flex">
                                <a class="btn btn-outline-dark me-2" title="Mostra"
                                    href="{{ route('admin.products.show', $product) }}"><i class="fa-solid fa-eye"></i>
                                </a>
                                <a class="btn btn-outline-dark me-2" title="Modifica"
                                    href="{{ route('admin.products.edit', $product) }}"><i class="fa-solid fa-pen"></i>
                                </a>
                                @include('admin.partials.form-delete', [
                                    'route' => 'products',
                                    'message' => "Confermi l'eliminatione di $product->title ?",
                                    'entity' => $product,
                                ])
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Nessun prodotto presente</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="smartphone-cards">
            @forelse ($products as $product)
                <div class="card mb-4">
                    <div class="card-header fw-bold text-capitalize">
                        {{ $product->name }}
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">&euro; {{ number_format($product->price, 2, ',') }}</li>
                        <li class="list-group-item">
                            @if ($product->is_visible)
                                <i class="fa-solid fa-circle-check"></i> Visibile
                            @else
                                <i class="fa-solid fa-circle-xmark"></i> Non visibile
                            @endif
                        </li>
                        <div class="actions-index d-flex justify-content-center my-2">
                            <a class="btn btn-outline-dark me-2" title="Mostra"
                                href="{{ route('admin.products.show', $product) }}"><i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="btn btn-outline-dark me-2" title="Modifica"
                                href="{{ route('admin.products.edit', $product) }}"><i class="fa-solid fa-pen"></i>
                            </a>
                            @include('admin.partials.form-delete', [
                                'route' => 'products',
                                'entity' => $product,
                            ])
                        </div>
                    </ul>
                </div>
            @empty
                <p>Nessun prodotto presente</p>
            @endforelse
        </div>


    </div>
@endsection
