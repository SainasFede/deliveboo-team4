<div class="d-flex align-items-center justify-content-between my-5">
    <a href="{{ route('admin.products.index') }}" title="Go back" class="btn btn-outline-dark me-3">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <h1 class="name-pc-tablet text-capitalize">
        @if (Route::currentRouteName() === 'admin.products.create')
            Crea un nuovo prodotto
        @elseif (Route::currentRouteName() === 'admin.products.edit')
            Modifica {{ $product->name }}
        @elseif (Route::currentRouteName() === 'admin.products.show')
            {{ $product->name }}
        @endif
    </h1>

    <div class="d-flex align-items-center">
        @if (Route::currentRouteName() != 'admin.products.create')
            @if (Route::currentRouteName() != 'admin.products.edit')
                <a href="{{ route('admin.products.edit', $product) }}" title="Modifica" class="btn btn-outline-dark me-3">
                    <i class="fa-solid fa-pen"></i>
                </a>
            @endif

            @include('admin.partials.form-delete', [
                'route' => 'products',
                'entity' => $product,
            ])

        @endif
    </div>
</div>
