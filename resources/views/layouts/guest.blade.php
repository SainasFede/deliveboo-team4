<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DeliveBoo</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href=" {{ Vite::asset('resources/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href=" {{ Vite::asset('resources/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href=" {{ Vite::asset('resources/img/favicon-16x16.png') }}">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css'
        integrity='sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ=='
        crossorigin='anonymous' />

    <!-- Scripts -->
    <script src="https://js.braintreegateway.com/web/dropin/1.34.0/js/dropin.min.js"></script>
    @vite(['resources/js/appVue.js', 'resources/scss/appVue.scss'])
</head>

<body class="font-sans text-gray-900 antialiased">
    @yield('content')
</body>

</html>
