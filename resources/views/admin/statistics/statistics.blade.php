@extends('layouts.app')

@section('title')
    | Statistiche
@endsection

@section('content')
    <div class="container">
        <h2 class="my-5">Statistiche Ristorante
            @if (request()->segment(2) == 'statistics' && request()->segment(3) == '')
                <span> - Ultimi 6 mesi</span>
            @elseif(request()->segment(4) == 'year' && is_numeric(request()->segment(5)))
                <span> - Anno {{ request()->segment(5) }} </span>
            @endif

        </h2>
        <div class="years-statistics mb-4 text-center">
            @foreach ($years as $year)
                <a class="btn {{ request()->segment(5) == $year ? 'btn-g-active' : 'btn-outline-dark' }}"
                    href="{{ route('admin.statisticsByYear', $year) }}">{{ $year }}</a>
            @endforeach
            <a class="btn {{ request()->segment(2) == 'statistics' && request()->segment(3) == '' ? 'btn-g-active' : 'btn-outline-dark' }} "
                href="{{ route('admin.statistics') }}">Ultimi 6 mesi</a>
        </div>

            <div class="chart-box d-flex w-100">
                <div class="card p-3 me-5">
                    <canvas id="chartOrders"></canvas>
                </div>
                <div class="card p-3">
                    <canvas id="chartSales"></canvas>
                </div>
            </div>
        @if (empty($statistics_data['numb_orders_by_month']['months']))
            <h4 class="mt-3 text-center">Nessuna statistica presente</h4>
        @endif
    </div>
@endsection

@section('script')
    <script>
        const ordersByMonth = {{ Js::from($statistics_data['numb_orders_by_month']) }};
        const salesByMonth = {{ Js::from($statistics_data['$sales_by_month']) }};
    </script>
@endsection
