<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo.adminkit.io/pages-settings.html" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="apple-touch-icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" href="/assets/favicon.ico">
    <link rel="shortcut icon" href="/assets/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/favicon.ico" />

    <title>Tru Tiên Tuổi Thơ - Phiên Bản 14 class</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Choose your prefered color scheme -->
    <!-- <link href="css/light.css" rel="stylesheet"> -->
    <!-- <link href="css/dark.css" rel="stylesheet"> -->

    <!-- BEGIN SETTINGS -->
    <!-- Remove this after purchasing -->
    <link class="js-stylesheet" href="/static/css/light.css" rel="stylesheet">
    <link class="js-stylesheet" href="/static/css/custom.css" rel="stylesheet">
    <style>
        body {
            opacity: 0;
        }
    </style>
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">

                <div class="sidebar-user">
                    <div class="d-flex justify-content-center">
                        <a href="/account" class="flex-shrink-0">
                            <img src="/assets/newlogo.png" class="avatar img-fluid rounded me-1" alt="Charles Hall"
                                style="width: 100px; height:100px" />
                        </a>
                    </div>
                </div>

                @include('account.layouts.menuitem')

                <div class="sidebar-cta">
                    <div class="sidebar-cta-content">
                        <div class="d-grid">
                            <a href="/" class="btn btn-outline-primary" target="_blank">Trang Chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                @include('account.layouts.info-box')
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h6 class="alert-heading"><i
                                    class="align-middle me-2 fas fa-fw fa-exclamation-triangle"></i>Đã có lỗi xảy ra
                            </h6>
                            <p>{{ $errors->first() }}</p>
                        </div>
                    </div>
                    @endif
                    @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h6 class="alert-heading"><i class="align-middle me-2 fas fa-fw fa-check-circle"></i>Xin
                                chúc mừng!</h6>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    </div>
                    @endif

                    @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h6 class="alert-heading"><i
                                    class="align-middle me-2 fas fa-fw fa-exclamation-triangle"></i>Đã có lỗi xảy ra!
                            </h6>
                            <p>{{ Session::get('error') }}</p>
                        </div>
                    </div>
                    @endif
                    @yield('content')

                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="/" target="_blank" class="text-muted"><strong>TruTienTuoiTho</strong></a>
                                &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Trang Chủ</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Tải Game</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Tin Tức</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Hướng Dẫn</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="/static/js/app.js"></script>
</body>

</html>