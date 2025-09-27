@php
$currentRoute = Route::currentRouteName();
@endphp
<style>
    nav a span {
        text-transform: capitalize !important;
    }
</style>
<nav class="sidebar-nav">
    <a href="/" class="" onclick="handleMobileNavClick(event, '/')">
        <span><i class="fa-solid fa-user"></i> Thông Tin Tài Khoản </span>
    </a>

    <a href="/ingame" class="{{ $currentRoute == 'ingame' ? 'active' : null }}" onclick="handleMobileNavClick(event, '/ingame')">
        <span>⚔️ Lịch sử Boss </span>
    </a>

    {{-- <a href="/pk" class="{{ $currentRoute == 'pk' ? 'active' : null }}" onclick="handleMobileNavClick(event, '/pk')">
        <span>⚔️ Hoạt động PvP và PK </span>
    </a> --}}

    <a href="/doi-mon-phai" class="{{ $currentRoute == 'changeClass' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/doi-mon-phai')">
        <span><i class="fa-solid fa-rotate"></i> Đổi Môn Phái</span>
    </a>
    <a href="/dich-vu" class="{{ $currentRoute == 'services' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/dich-vu')">
        <span><i class="fa-solid fa-gear"></i> Dịch vụ game</span>
    </a>
    <a href="/nap-tien" class="{{ $currentRoute == 'payment' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/nap-tien')">
        <span><i class="fa-solid fa-credit-card"></i> Nạp Tiền</span>
    </a>
    <a href="/knb" class="{{ $currentRoute == 'knb' ? 'active' : null }}" onclick="handleMobileNavClick(event, '/knb')">
        <span><i class="fa-solid fa-coins"></i> Đổi KNB</span>
    </a>
    <a href="/shops" class="{{ $currentRoute == 'shops' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/shops')">
        <span><i class="fa-solid fa-gem"></i> Web Shop</span>
    </a>
    <a href="/shop-xu-web" class="{{ $currentRoute == 'shop-coin' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/shop-xu-web')">
        <span><i class="fa-solid fa-gem"></i> Shop Xu Event <span class="badge-new">Mới</span></span>
    </a>
    <a href="/giftcodes" class="{{ $currentRoute == 'giftcodes' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/giftcodes')">
        <span><i class="fa-solid fa-gifts"></i> Giftcode</span>
    </a>
    <a href="/ruong-may-man" class="{{ $currentRoute == 'shake' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/ruong-may-man')" style="position: relative;">
        <span><i class="fa-solid fa-toolbox"></i> Rương May Mắn</span>
    </a>
    <a href="/nhiem-vu" class="{{ $currentRoute == 'quests' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/nhiem-vu')" style="position: relative;">
        <span><i class="fa-solid fa-list"></i> Nhiệm Vụ Hàng Ngày <span class="badge-new">Mới</span></span>
    </a>
    <a href="/thanh-tuu" class="{{ $currentRoute == 'rewards' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/thanh-tuu')" style="position: relative;">
        <span><i class="fa-solid fa-trophy"></i> Thành Tựu <span class="badge-new">Mới</span></span>
    </a>
    <a href="/logout" onclick="handleMobileNavClick(event, '/logout')">
        <span><i class="fa-solid fa-sign-in"></i> Thoát</span>
    </a>
</nav>