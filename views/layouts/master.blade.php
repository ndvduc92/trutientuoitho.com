<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tru Tiên Việt Nam - Phiên Bản 18 class</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&amp;family=Noto+Sans:wght@300;400;500;700&amp;display=swap"
        rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="/cdn/icon.png">

    <!-- Main stylesheets -->
    <link rel="stylesheet" type="text/css" href="/static/accounts.css">
    <link rel="stylesheet" type="text/css" href="/static/windowstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="/spin/AdminLTE-3.1.0/plugins/toastr/toastr.min.css">
    <script src="/spin/AdminLTE-3.1.0/plugins/toastr/toastr.min.js"></script>
    <!-- JavaScript -->
    <script src="/static/accounts.js"></script>

    <style>
        .vip {
            width: 40px;
            height: 30px;
            display: inline-block;
            vertical-align: middle;
        }

        .vip.lvl1 {
            background: url(/static/vipsymbol.png) 0 0;
        }

        .vip.lvl2 {
            background: url(/static/vipsymbol.png) 0 -30px;
        }

        .vip.lvl3 {
            background: url(/static/vipsymbol.png) 0 -60px;
        }

        .vip.lvl4 {
            background: url(/static/vipsymbol.png) 0 -90px;
        }

        .vip.lvl5 {
            background: url(/static/vipsymbol.png) 0 -120px;
        }

        .vip.lvl6 {
            background: url(/static/vipsymbol.png) 0 -150px;
        }

        .vip.lvl7 {
            background: url(/static/vipsymbol.png) 0 -180px;
        }

        .vip.lvl8 {
            background: url(/static/vipsymbol.png) 0 -210px;
        }

        .blink-text {
            animation: blinkHighlight 1s infinite;
        }

        @keyframes blinkHighlight {
            0% {
                color: #FFD700;
                /* Vàng sáng */
                text-shadow: 0 0 10px #FFD700;
            }

            50% {
                color: #fff;
                /* Trắng */
                text-shadow: 0 0 20px #fff;
            }

            100% {
                color: #FFD700;
                text-shadow: 0 0 10px #FFD700;
            }
        }
    </style>

</head>

<body cz-shortcut-listen="true">
    <!-- Mobile sidebar overlay -->
    <div class="mobile-sidebar-overlay" id="mobileSidebarOverlay" onclick="toggleMobileSidebar()"></div>

    <div style="display:none;" id="initial-points-data">
        <span id="User_Point">0</span>
    </div>
    @include('layouts.header')
    <!-- Toggle Button -->
    @include('layouts.float')

    <div class="jade-dashboard-grid">
        <div class="jade-sidebar" id="mobileSidebar">
            <button class="mobile-close-btn" onclick="toggleMobileSidebar()">
                <i class="fas fa-times"></i>
            </button>
            @include('layouts.menu')
        </div>
        <div class="jade-main-content">
            @if ($errors->any())
            <div id="error-alert" class="alert alert-danger">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <span id="error-message">{{ $errors->first() }}</span>
            </div>
            @endif

            @if (Session::has('success'))
            <div id="success-alert" class="alert alert-success">
                <i class="fas fa-check-circle alert-icon"></i>
                <span id="success-message">{{ Session::get('success') }}</span>
            </div>
            @endif

            @if (request('error') == 'auth_required')
            <div id="error-alert" class="alert alert-danger">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <span id="error-message">Bạn cần đăng nhập để tiếp tục</span>
            </div>
            @endif

            @if (Session::has('error'))
            <div id="error-alert" class="alert alert-danger">
                <i class="fas fa-exclamation-circle alert-icon"></i>
                <span id="error-message">{{ Session::get('error') }}</span>
            </div>
            @endif
            @yield('content')
        </div>
    </div>
    {{-- <footer class="footer">
        <p>© 2025 Tru Tiên Việt Nam. All rights reserved.</p>
    </footer> --}}
</body>

<script>
    function toggleMobileSidebar() {
        var sidebar = document.getElementById('mobileSidebar');
        var overlay = document.getElementById('mobileSidebarOverlay');
        if (sidebar.classList.contains('mobile-active')) {
            sidebar.classList.remove('mobile-active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        } else {
            sidebar.classList.add('mobile-active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    // Handle mobile navigation clicks
    function handleMobileNavClick(event, url) {
        // Only handle on mobile
        if (window.innerWidth <= 992) {
            event.preventDefault();
            toggleMobileSidebar();
            // Navigate after animation
            setTimeout(function() {
                window.location.href = url;
            }, 300);
        }
    }
    // Create floating particles
    function createParticles() {
        var particlesContainer = document.getElementById('particles');
        if (!particlesContainer) return;
        // Create 50 particles
        for (var i = 0; i < 50; i++) {
            var particle = document.createElement('span');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (15 + Math.random() * 10) + 's';
            particlesContainer.appendChild(particle);
        }
    }

    // Handle window resize
    function handleResize() {
        // Close mobile sidebar on resize to desktop
        if (window.innerWidth > 992) {
            var sidebar = document.getElementById('mobileSidebar');
            var overlay = document.getElementById('mobileSidebarOverlay');
            
            if (sidebar && sidebar.classList.contains('mobile-active')) {
                sidebar.classList.remove('mobile-active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    }
    // Initialize timers and dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Create particles
        createParticles();
        // Handle window resize
        window.addEventListener('resize', handleResize);
    });
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 10000);
</script>

</html>