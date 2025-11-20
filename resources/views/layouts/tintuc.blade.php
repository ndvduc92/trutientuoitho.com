<section class="news">
    <div class="container">
        <div class="title"><img class="img-fluid" src="/assets/title_news.png"></div>
        <div class="news_contnet">
            <div class="row no-gutters h-100">
                <div class="col-lg-6">
                    <div id="ubanner_A" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="swiper bannerSwiper swiper-initialized swiper-horizontal swiper-pointer-events">
                            <div class="swiper-wrapper" id="swiper-wrapper-d74b1f2c6ceeb595" aria-live="polite"
                                style="transform: translate3d(0px, 0px, 0px);">
                                <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 1"
                                    style="width: 555px;">
                                    <a href="javascript:void(0);"><img
                                            src="/assets/bf492c38cc924bebab6e97ceda21f95d.jpg"></a>
                                </div>
                            </div>
                            <div class="swiper-button-prev swiper-button-disabled swiper-button-lock" tabindex="-1"
                                role="button" aria-label="Previous slide"
                                aria-controls="swiper-wrapper-d74b1f2c6ceeb595" aria-disabled="true">
                            </div>
                            <div class="swiper-button-next swiper-button-disabled swiper-button-lock" tabindex="-1"
                                role="button" aria-label="Next slide" aria-controls="swiper-wrapper-d74b1f2c6ceeb595"
                                aria-disabled="true"></div>
                            <div
                                class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal swiper-pagination-lock">
                                <span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0"
                                    role="button" aria-label="Go to slide 1"></span>
                            </div>
                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="news_list">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="system-more">
                                    <img class="img-fluid" src="/assets/news_list_top.png">
                                    <span class="news_title"></span>
                                    <a class="more" href="/tin-tuc">Xem Thêm</a>
                                </div>
                                <div id="news_list">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($posts as $post)
                                        <li class="system-single">
                                            <a class="systemurl" href="/tin-tuc/{{ $post->slug }}">
                                                <div class="row system-details">
                                                    <div class="col-lg-9 col-8 align-self-center"><span
                                                            class="system-title">{{ $post->title }}</span>
                                                    </div>
                                                    <div class="col-lg-3 col-4 align-self-center"><span
                                                            class="systemtime">{{
                                                            \Carbon\Carbon::parse($post->created_at)->format('d/m/Y')
                                                            }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="news_btn">
                                    <div class="row no-gutters">
                                        <div class="col-6 pr-1"><a href="https://www.facebook.com/" target="_blank"><img
                                                    class="img-fluid" src="/assets/btn_facebook.png"></a></div>
                                        <div class="col-6 pl-1"><a href="https://discord.com/channels/"
                                                target="_blank"><img class="img-fluid"
                                                    src="/assets/btn_discord.png"></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
