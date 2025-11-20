<div class="section-1">
    <div class="container">
        <div class="swiper-container banner-slider swiper-container-initialized swiper-container-horizontal">
            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                <div class="swiper-slide swiper-slide-active" style="width: 441px;">
                    <a href="#" target="_blank">
                        <img src="/assets/ltk.jpg" alt="225" width="441" height="354">
                    </a>
                </div>
                <div class="swiper-slide swiper-slide-next" style="width: 441px;">
                    <a href="#" target="_blank">
                        <img src="/assets/bd.jpg" alt="224" width="441" height="354">
                    </a>
                </div>
                <div class="swiper-slide" style="width: 441px;">
                    <a href="#" target="_blank">
                        <img src="/assets/ql.jpg" alt="223">
                    </a>
                </div>
                <div class="swiper-slide" style="width: 441px;">
                    <a href="h#" target="_blank">
                        <img src="/assets/ltk.jpg" alt="222">
                    </a>
                </div>
            </div>
            <div class="swiper-pagination swiper-pagination-bullets"><span
                    class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span
                    class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet"></span><span
                    class="swiper-pagination-bullet"></span></div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
        <div class="news">
            <ul class="nav news-tab">
                <li><img src="/assets/wmlogo_en_black.png" alt=""></li>
            </ul>
            <div class="tab-content">
                <div>
                    <ul class="news-list">
                        @foreach ($posts as $post)
                            <li class="{{ $loop->index == 0 ? 'highlight' : '' }}">
                                <a class="news-title" href="/tin-tuc/{{ $post->slug }}" title="{{ $post->title }}">
                                    @if ($loop->index == 0)
                                        <img src="/assets/news-new-icon.jpg?ver=2.3" alt="">
                                    @endif
                                    <span>
                                        {{ $post->title }}
                                    </span>
                                    <time class="news-time"
                                        datetime="{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</time>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <a class="news-more" href="/tin-tuc" title="xem thêm">
                        <img src="/assets/xemthem-btn.jpg?ver=2.3" alt="">
                    </a>
                </div>
            </div>
        </div>
       
    </div>
</div>

<style>
    .btns {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        position: absolute;
        right: 0;
        bottom: 10px;
        left: 0
    }

    .btns a {
        display: block;
        margin: 0 5px
    }

    .btns a:hover {
        -webkit-filter: brightness(110%);
        filter: brightness(110%)
    }

    body .section-1 {
        background: url(./assets/news-bg.png) no-repeat top center;
        padding: 35px 0 30px 115px
    }

    body .section-1 .container,
    body .section-1 .header-container {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        margin: 0 auto 60px;
        padding: 0 5px 0
    }

    .banner-slider {
        width: 441px;
        margin: 0 20px 0 0;
        padding: 0;
        position: relative
    }

    .banner-slider .swiper-slide {
        line-height: .5;
        display: block
    }

    .banner-slider .swiper-slide a {
        display: block
    }

    .banner-slider .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background-color: #0c1410 !important;
        opacity: 1 !important
    }

    .banner-slider .swiper-pagination-bullet-active {
        background-color: #a81919 !important
    }

    .buttons {
        width: 102px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-flow: column;
        -ms-flex-flow: column;
        flex-flow: column;
        line-height: .7;
        margin: 0 0 0 45px
    }

    .buttons a:not(:last-child) {
        margin-bottom: 15px
    }

    .buttons a:hover {
        -webkit-filter: brightness(120%);
        filter: brightness(120%)
    }

    .news {
        margin: 0 10px 0 0;
        width: 475px;
        padding: 15px 0;
        position: relative;
        z-index: 1
    }

    .news-tab {
        overflow: hidden;
        padding: 0 0 0;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .news-tab li a {
        width: auto;
        display: block;
        font-family: robotoslab;
        color: #35353c;
        text-transform: uppercase;
        text-align: center;
        font-weight: 700;
        font-size: 14px;
        background: 0 0;
        padding: 0 10px 10px;
        border-bottom: solid 3px transparent
    }

    .news-tab li a.active,
    .news-tab li a:hover {
        color: #b48300;
        border-bottom: solid 3px #694f32
    }

    .news-tab li:not(:last-child) a {
        border-right: none
    }

    .news .tab-content {
        padding: 10px 0
    }

    .heading {
        height: 56px;
        line-height: 56px;
        color: #dab979;
        text-transform: uppercase;
        text-align: center;
        font-weight: 700;
        font-size: 18px;
        font-family: robotoslab;
        margin: 0 auto 20px
    }

    ul.news-list {
        margin: 0 0 10px;
        font-size: 15px
    }

    ul.news-list li {
        width: 100%;
        overflow: hidden;
        padding: 0 15px 0 0;
        margin: 0 0 2px 0;
        position: relative
    }

    ul.news-list li:not(:last-child) {
        border-bottom: 1px solid #ebe7e3
    }

    ul.news-list li a {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -webkit-justify-content: space-between;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center
    }

    ul.news-list li.highlight {
        background: #212131;
        margin: 0 0 10px
    }

    ul.news-list li.highlight .news-title {
        width: 100%;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        color: #b48300;
        font-family: SF-Bold;
        font-size: 15px
    }

    ul.news-list li.highlight .news-title:hover {
        color: #be351f
    }

    ul.news-list li.highlight .news-title:hover .news-time {
        color: #be351f
    }

    ul.news-list li.highlight .news-title .news-time {
        color: #b48300
    }

    ul.news-list li.highlight .news-title span {
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis
    }

    ul.news-list li .news__thumb {
        float: left;
        margin: 2px 10px 0 1px;
        height: auto
    }

    ul.news-list li .news__thumb img {
        border: 2px solid #3c365a
    }

    ul.news-list li .news-des {
        width: calc(100% - 235px);
        color: #25526b;
        float: left;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        padding-bottom: 0 !important
    }

    ul.news-list li .news-title {
        color: #35353c;
        width: 100%
    }

    ul.news-list li .news-title:hover,
    ul.news-list li .news-title:hover .news-time {
        color: #be351f
    }

    ul.news-list li .news-title span {
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        overflow: hidden;
        display: block;
        padding: 0 10px;
        white-space: nowrap;
        line-height: 2
    }

    ul.news-list li .news-time {
        color: #35353c;
        text-align: right
    }

    .news-more {
        display: inline-block;
        color: #e3edf1;
        font-size: 15px;
        float: right;
        margin: 0;
        padding: 0;
        position: relative;
        line-height: 25px
    }
</style>
