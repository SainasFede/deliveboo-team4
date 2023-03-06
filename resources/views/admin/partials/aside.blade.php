<nav class="aside">
    <ul>
        <li
            class="{{ (request()->segment(2) == '' ? 'active' : '' || request()->segment(2) == 'restaurants') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-utensils"></i>
                <span>Ristorante</span>
            </a>
        </li>

        <li class="{{ request()->segment(2) == 'products' ? 'active' : '' }}">
            <a href="{{ route('admin.products.index') }}">
                <i class="fa-solid fa-pizza-slice"></i>
                <span>Prodotti</span>
            </a>
        </li>

        <li class="{{ request()->segment(2) == 'orders' ? 'active' : '' }}">
            <a href="{{ route('admin.orders.index') }}">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Ordini</span>
            </a>
        </li>

        <li class="{{ request()->segment(2) == 'statistics' ? 'active' : '' }}">
            <a href="{{ route('admin.statistics') }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Statistiche</span>
            </a>
        </li>
    </ul>
</nav>
