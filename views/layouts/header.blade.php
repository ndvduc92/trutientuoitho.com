<style>
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 70px;
        background-color: #1baac2;
        /* nền xanh nhạt */
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1.5rem;
        z-index: 1000;
    }

    /* Logo bên trái */
    .header .logo img {
        height: 100px;
        display: block;
    }

    /* Box trắng bên phải */
    .header-info-box {
        background-color: #fff;
        border-radius: 10px;
        padding: 0.5rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    /* Item trong box */
    .header-info-box span {
        font-size: 0.95rem;
        font-weight: 500;
        color: #333;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }

    /* Icon nhỏ */
    .icon {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #f39c12;
    }

    @media (max-width: 1024px) {
        .header-info-box {
            display: none;
        }
    }
</style>
<header class="header">
    <!-- Logo -->
    <div class="logo">
        <a href="/">
            <img src="/cdn/logo.png" alt="Logo">
        </a>
    </div>
    <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Box trắng -->
    <div class="header-info-box">
        <span class=""><span class="icon"></span><strong>ID:</strong> {{Auth::user()->userid}}</span>
        <span><span class="icon"></span><strong>TÀI KHOẢN:</strong> {{Auth::user()->username}}</span>
        <span><span class="icon"></span><strong>XU NẠP:</strong> {{number_format(Auth::user()->balance)}}</span>
        <span><span class="icon"></span><strong>XU WAR:</strong> {{ number_format(Auth::user()->war_point - Auth::user()->war_point_used) }}</span>
        <span><span class="icon"></span><strong>XU EVENT:</strong>{{number_format(Auth::user()->xu_event - Auth::user()->xu_event_used)}}</span>
    </div>
</header>