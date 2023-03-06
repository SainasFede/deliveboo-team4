<style>
    body {
        font-family: Arial, Helvetica, sans-serif
    }
</style>

<h3>Hai ricevuto un nuovo ordine!</h3>
<p style="text-trasform: capitalize; margin-top: 20px;">Cliente: <span style="text-transform: capitalize;">{{ $order->name }}</span> <span style="text-transform: capitalize;">{{ $order->surname }}</span>.</p>
<p>L'ordine deve essere consegnato presso {{ $order->address }}.</p>
@if ($order->note)
    <p style="margin-top: 20px;">Note dal cliente: <span style="text-transform: capitalize;">{{ $order->note }}</span>.</p>
@endif
<div style="margin-top: 30px; text-align: center;">
    <a style="text-align: center; text-decoration: none; font-weight:bold; padding: 10px; border-radius: 10px; background-color:#f15a25; color:#ffffff;"
        href="http://127.0.0.1:8000/admin/orders/{{ $order->id }}">Accedi alla tua area personale</a>
</div>

<div class="logo" style="text-align: center; margin-top: 40px;">
    <img style="width: 100px;" src="{{ Vite::asset('resources/img/logo.png') }}" alt="Logo">
</div>
