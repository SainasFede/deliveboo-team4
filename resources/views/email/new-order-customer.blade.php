<style>
    body {
        font-family: Arial, Helvetica, sans-serif
    }
</style>

<p style="text-trasform: capitalize;">Ciao <span style="text-transform: capitalize;">{{ $order->name }}</span>,</p>
<p>Grazie per aver ordinato su Deliveboo! Presto riceverai il tuo ordine da <span
        style="text-trasform: capitalize; font-weight: bolder;">{{ $order->restaurant->name }}.</span></p>

<h4 style="margin-top: 30px;">Riepilogo Ordine #{{$order->id}}:</h4>
<ul>
    @foreach ($order->products as $product)
        <li>{{ $product->quantity }}{{ $product->name }}: {{$product->pivot->quantity}} pz</li>
    @endforeach
</ul>
<h4>Totale: &euro;{{ number_format($order->amount, 2, ',', ' ') }}</h4>

<h4 style="margin-top: 30px; margin-bottom: 5px;">Indirizzo di consegna inserito</h4>
<p>{{ $order->address }}</p>

@if ($order->note)
    <h4 style="margin-top: 20px; margin-bottom: 5px;">Note lasciate per il ristorante</h4>
    <p style="text-transform: capitalize;">{{ $order->note }}</p>
@endif


<h4 style="margin-top: 20px; margin-bottom: 5px;">Per qualsiasi necessità puoi contattare il ristorante:</h4>
<p>{{ $order->restaurant->telephone }}</p>

<div class="logo" style="text-align: center; margin-top: 20px;">
    <img style="width: 100px;" src="{{ Vite::asset('resources/img/logo.png') }}" alt="Logo">
</div>
