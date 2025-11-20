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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />
    <link rel="apple-touch-icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" href="/assets/favicon.ico">
    <link rel="shortcut icon" href="/assets/favicon.ico" />
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/favicon.ico" />

    <title>Tru Tiên Tuổi Thơ - Phiên Bản 14 class</title>

    <link href="/static/css/light.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <img src="/assets/newlogo.png" alt="" style="width:50%">
                        </div>

                        @if ($errors->any())
                        <div class="alert alert-danger alert-outline-coloured alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                {{ $errors->first() }}
                            </div>
                        </div>
                        @endif

                        @if (Session::has('success'))
                        <div class="alert alert-success alert-outline-coloured alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                {{ Session::get('success') }}
                            </div>
                        </div>
                        @endif

                        @if (Session::has('error'))
                        <div class="alert alert-danger alert-outline-coloured alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                {{ Session::get('error') }}
                            </div>
                        </div>
                        @endif

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="/static/js/app.js"></script>

</body>

</html>