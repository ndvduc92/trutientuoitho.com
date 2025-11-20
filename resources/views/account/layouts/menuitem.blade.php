@php
$currentRoute = Route::currentRouteName();
@endphp

<ul class="sidebar-nav">
    <li class="sidebar-item">
        <a class='sidebar-link' href='/account'>
            <i class="align-middle" data-feather="slack"></i> <span class="align-middle">Đại Sảnh</span>
        </a>
    </li>

    <li class="sidebar-item {{ $currentRoute == 'giftcodes' ? 'active' : null }}">
        <a class='sidebar-link' href='/account/giftcodes'>
            <i class="align-middle me-2 fas fa-fw fa-gift"></i> <span class="align-middle">Giftcode</span>
        </a>
    </li>

    <li class="sidebar-item {{ $currentRoute == 'payment' ? 'active' : null }}">
        <a class='sidebar-link' href='/account/nap-tien'>
            <i class="align-middle me-2 fas fa-fw fa-money-bill"></i> <span class="align-middle">Nạp
                tiền</span>
        </a>
    </li>

    <li class="sidebar-item {{ $currentRoute == 'knb' ? 'active' : null }}">
        <a class='sidebar-link' href='/account/knb'>
            <i class="align-middle me-2 fas fa-fw fa-coins"></i> <span class="align-middle">Đổi
                KNB</span>
        </a>
    </li>

    <li class="sidebar-item {{ $currentRoute == 'shops' ? 'active' : null }}">
        <a class='sidebar-link' href='#'>
            <i class="align-middle me-2 fas fa-fw fa-paper-plane"></i> <span class="align-middle">Cửa
                Hàng</span>
        </a>
    </li>


    <li class="sidebar-item">
        <a class='sidebar-link' href='/account/rung-cay'>
            <i class="align-middle me-2 fas fa-fw fa-tree"></i> <span class="align-middle">Rung
                Cây</span>
            <span class="sidebar-badge badge bg-danger">Mới</span>
        </a>
    </li>

    <li class="sidebar-item">
        <a class='sidebar-link' href='/account/logout'>
            <i class="align-middle me-1" data-feather="log-out"></i> Thoát ra
        </a>
    </li>
</ul>