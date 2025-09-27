@php
$currentRoute = Route::currentRouteName();
@endphp
<nav class="sidebar-nav">
    <a href="/" class="" onclick="handleMobileNavClick(event, '/')">
        <span><i class="fa-solid fa-user"></i> Thông tin tài khoản </span>
    </a>
    <!--<a href="/event" class="{{ $currentRoute == 'event' ? 'active' : null }}" onclick="handleMobileNavClick(event, '/event')">-->
    <!--    <span class="blink-text">🔽 Miễn phí đổi môn phái</span>-->
    <!--</a>-->
    {{-- <a href="/title" class="{{ $currentRoute == 'title' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/title')">
        <span class="blink-text">💥 Đặt tôn hiệu riêng</span>
    </a> --}}
    {{-- <a href="/tai-game" class="{{ $currentRoute == 'war' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/tai-game')">
        <span class="">Tải client mới</span>
    </a> --}}
    {{-- <a href="/bang-chien" class="{{ $currentRoute == 'war' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/bang-chien')">
        <span>⚔️ Bang Chiến</span>
    </a>
    <a href="/meta" class="{{ $currentRoute == 'meta' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/meta')">
        <span>️🎭 Quản lý tài khoản phụ</span>
    </a>
    <a href="/inventory" class="{{ $currentRoute == 'inventory' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/inventory')">
        <span>👜 Túi đồ</span>
    </a>
    <a href="/offline" class="{{ $currentRoute == 'offline' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/offline')">
        <span>🔮 Treo máy offline</span>
    </a>
    <a href="/tro-chuyen" class="{{ $currentRoute == 'chat' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/tro-chuyen')">
        <span>🗨 Phi cáp truyền thư</span>
    </a>
    <a href="/auto" class="{{ $currentRoute == 'auto' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/auto')">
        <span>️🎯 Giảm lag và auto</span>
    </a>
    <a href="https://wiki.trutienvietnam.com/" target="_blank" class="{{ $currentRoute == 'help' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/huong-dan')">
        <span>🔎 Hướng dẫn tân thủ</span>
    </a>
    <a href="/bang-hoi" class="{{ $currentRoute == 'guild' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/bang-hoi')">
        <span>️🎠 Bang hội</span>
    </a>
    <a href="/bang-xep-hang" class="{{ $currentRoute == 'rank' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/bang-xep-hang')">
        <span>️🥇 Bảng phong thần</span>
    </a> --}}
    {{-- <a href="/dich-vu" class="{{ $currentRoute == 'services' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/dich-vu')">
        <span>🐉 Dịch vụ game</span>
    </a>
    <a href="/ca-nhan" class="{{ $currentRoute == 'profile' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/ca-nhan')">
        <span>🧘 Tài khoản</span>
    </a>

    <a href="/nhan-vat" class="{{ $currentRoute == 'chars' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/nhan-vat')">
        <span>️️☪️ Nhân vật</span>
    </a> --}}

    <a href="/doi-mon-phai" class="{{ $currentRoute == 'changeClass' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/doi-mon-phai')">
        <span><i class="fa-solid fa-rotate"></i> Đổi môn phái</span>
    </a>
    <a href="/nap-tien" class="{{ $currentRoute == 'payment' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/nap-tien')">
        <span><i class="fa-solid fa-dollar-sign"></i> Nạp tiền</span>
    </a>
    <a href="/knb" class="{{ $currentRoute == 'knb' ? 'active' : null }}" onclick="handleMobileNavClick(event, '/knb')">
        <span><i class="fa-solid fa-coins"></i> Đổi KNB</span>
    </a>
    {{-- <a href="/mini-game" class="{{ $currentRoute == 'game' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/mini-game')">
        <span>🎮 Mini game</span>
    </a>
    <a href="/packs" class="{{ $currentRoute == 'packs' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/packs')">
        <span>👜 Gói ưu đãi</span>
    </a>
    <a href="/wars" class="{{ $currentRoute == 'wars' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/wars')">
        <span>⚔️ Shop Bang Chiến</span>
    </a> --}}
    <a href="/shops" class="{{ $currentRoute == 'shops' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/shops')">
        <span><i class="fa-solid fa-gem"></i> Web shop</span>
    </a>
    {{-- <a href="/shop-xu-web" class="{{ $currentRoute == 'shop-coin' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/shop-xu-web')">
        <span>️🤹 Linh Bảo Các</span>
    </a>
    <a href="/thanh-tuu" class="{{ $currentRoute == 'rewards' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/thanh-tuu')">
        <span>🏆 Thành Tựu</span>
    </a>
    <a href="/nhiem-vu" class="{{ $currentRoute == 'quests' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/nhiem-vu')">
        <span style="">📜 Nhiệm vụ mỗi ngày</span>
    </a> --}}
    <a href="/giftcodes" class="{{ $currentRoute == 'giftcodes' ? 'active' : null }}"
        onclick="handleMobileNavClick(event, '/giftcodes')">
        <span><i class="fa-solid fa-gifts"></i> Giftcode</span>
    </a>
    {{-- <a href="referrals.php" onclick="handleMobileNavClick(event, 'referrals.php')">
        <i class="fas fa-user-plus"></i>
        <span>Referrals</span>
    </a>
    <a href="votepage.php" onclick="handleMobileNavClick(event, 'votepage.php')">
        <i class="fas fa-vote-yea"></i>
        <span>Vote</span>
    </a> --}}
    {{-- <a href="/rung-cay" onclick="handleMobileNavClick(event, '/rung-cay')"
        class="{{ $currentRoute == 'shake' ? 'active' : null }}">
        <span>Rung cây phát lộc</span>
    </a> --}}
    <a href="/logout" onclick="handleMobileNavClick(event, '/logout')">
        <span><i class="fa-solid fa-sign-in"></i> Thoát</span>
    </a>
</nav>