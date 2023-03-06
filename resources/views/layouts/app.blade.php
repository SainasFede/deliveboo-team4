<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DeliveBoo @yield('title')</title>

    <!-- Font Awesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css'
        integrity='sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ=='
        crossorigin='anonymous' />

    <!-- Ckeditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        {{-- header --}}
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container-fluid collapse-background">

                <a class="navbar-brand d-flex align-items-center" href="{{ url('/admin') }}">
                    <div class="logo_laravel text-white d-flex align-items-center">
                        <img class="me-2" style="width: 25px" src="{{ Vite::asset('resources/img/logo.png') }}"
                            alt="Logo">
                        DeliveBoo
                    </div>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    {{-- <span class="navbar-toggler-icon"></span> --}}
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto nav-header-custom">
                        @auth

                            <li class="nav-item">
                                <a class="nav-link me-3" href="{{ route('admin.restaurants.index') }}">
                                    <i class="fa-solid fa-utensils me-2"></i>Ristorante
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link me-3" href="{{ route('admin.orders.index') }}">
                                    <i class="fa-solid fa-cart-shopping me-2"></i>Ordini
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link me-3" href="{{ route('admin.products.index') }}">
                                    <i class="fa-solid fa-pizza-slice me-2"></i>Prodotti
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link me-3" href="{{ route('admin.statistics') }}">
                                    <i class="fa-solid fa-chart-pie me-2"></i>Statistiche
                                </a>
                            </li>

                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::currentRouteName() === 'register')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @elseif (Route::currentRouteName() === 'login')
                                <li class="nav-item">
                                    <a class="nav-link  " href="{{ route('register') }}">{{ __('Registrati') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu mb-2" style="right: 5px; left: auto;"
                                    aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ url('/') }}"><i
                                            class="fa-solid fa-globe me-2"></i>Torna al sito pubblico</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket me-2 text-danger"></i>Esci
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid main-wrapper">
            <div class="row">
                @auth
                    <div class="col-1 aside">
                        @include('admin.partials.aside')
                    </div>
                @endauth
                <div class="@auth col-11 @endauth content">
                    <main>
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>

    @yield('script')
</body>

</html>
