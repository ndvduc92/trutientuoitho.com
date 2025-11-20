<nav>
    <div class="container">
        <div class="menu">
            <ul>
                <li><a href="/" class="home">Trang Chủ</a></li>
                <li><a href="https://news.trutientuoitho.com" target="_blank">Tin Tức</a></li>
                <li><a href="/tai-game">Tải Game</a></li>
                <li><a href="https://news.trutientuoitho.com" target="_blank">Hướng Dẫn</a></li>
                </li>
                <li>
                    @if(Auth::check())
                    <a href="/account" target="_blank">Xin chào <span class="text-danger">[{{Auth::user()->name}}]</span></a>
                    @else
                    <a href="/account" target="_blank">Đăng Ký</a>
                    @endif
                </li>
            </ul>
        </div>

        <div class="open_menu">
            <span class="btn">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </div>
    </div>
</nav>