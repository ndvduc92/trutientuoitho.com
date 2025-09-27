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
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="/cdn/icon.png">

    <!-- Main stylesheets -->
    <link rel="stylesheet" type="text/css" href="/static/jade-dynasty-main.css">
    <link rel="stylesheet" type="text/css" href="/static/accounts.css">
    <link rel="stylesheet" type="text/css" href="/static/windowstyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="/spin/AdminLTE-3.1.0/plugins/toastr/toastr.min.css">
    <script src="/spin/AdminLTE-3.1.0/plugins/toastr/toastr.min.js"></script>
    <!-- JavaScript -->
    <script src="/static/accounts.js"></script>
    <style>
        .form-actions {
            display: flex;
            justify-content: center !important;
            gap: 15px;
            margin-top: 30px;
        }

        .jade-dashboard-grid {
            display: block;
            width: 50%
        }

        @media (max-width: 1024px) {
            .jade-dashboard-grid {
                width: 90%;
            }
        }

        .logo {
            display: inline-block;
            position: relative;
            animation: float 3s ease-in-out infinite;
            text-align: center;
            margin-bottom: -30px !important;
        }

        .logo img {
            width: 200px;
            /* chỉnh kích thước logo */
            transition: transform 0.3s ease;
        }

        /* Hover phóng to nhẹ + xoay chút */
        .logo img:hover {
            transform: scale(1.08) rotate(-2deg);
        }

        /* Hiệu ứng nổi lên xuống */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body cz-shortcut-listen="true">
    <!-- Mobile sidebar overlay -->
    <div class="jade-dashboard-grid" style="">
        <div class="jade-main-content">
            <a href="/dang-nhap" class="logo"><img src="/cdn/logo.png" alt="" srcset=""></a>

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
</body>

</html>