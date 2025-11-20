@extends('layouts.app')
@section('content')
    <section class="news_banner">
        <img class="img-fluid d-none d-lg-block" src="/assets/news_banner.jpg">
        <img class="img-fluid d-lg-none" src="/assets/news_banner_m.jpg">
    </section>
    <section class="newsdetails">
        <div class="container">



            <div class="newsdetails-contents">
                <div class="container">
                    <div class="portfolio-menu mt-2 mb-4">
                        <ul style="text-align: center;">
                            <li class=" active" data-filter=".image"><img class="img-fluid" src="https://st1.cmn.vn/games/chien-tam-quoc/mainsite/images/title-dacsac.png?ver=1.8"></li>
                        </ul>
                    </div>
                    <div class="portfolio-item row">
                        @for ($i = 1; $i < 41; $i++)
                        <div class="item image col-lg-3 col-md-4 col-6 col-sm">
                            <a href="/assets/lib/{{$i}}.jpg" class="fancylight popup-btn" data-fancybox-group="light">
                                <img class="img-fluid" src="/assets/lib/{{$i}}.jpg" alt="">
                            </a>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.info')
    <style>
        .portfolio-menu {
            text-align: center;
        }

        .portfolio-menu ul li {
            display: inline-block;
            margin: 0;
            list-style: none;
            padding: 10px 15px;
            cursor: pointer;
            -webkit-transition: all 05s ease;
            -moz-transition: all 05s ease;
            -ms-transition: all 05s ease;
            -o-transition: all 05s ease;
            transition: all .5s ease;
        }

        .portfolio-item {
            /*width:100%;*/
        }

        .portfolio-item .item {
            /*width:303px;*/
            float: left;
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
    <script>
        $('.portfolio-menu ul li').click(function() {
            $('.portfolio-menu ul li').removeClass('active');
            $(this).addClass('active');

            var selector = $(this).attr('data-filter');
            $('.portfolio-item').isotope({
                filter: selector
            });
            return false;
        });
        $(document).ready(function() {
            var popup_btn = $('.popup-btn');
            popup_btn.magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
    </script>
@endsection
