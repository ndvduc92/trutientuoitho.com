var widthWD;
var heightWD;

$(document).ready(function () {
    widthWD = jQuery(window).width();
    heightWD = jQuery(document).height();
    new Swiper(".banner-slider", {
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
    });

    /*---- Top Button -----*/
    jQuery(".top").click(function () {
        jQuery("html, body").animate({ scrollTop: 0 }, 300);
    });
    /*---- End Top Button -----*/

    jQuery(document).on("click", ".giftcode", function (event) {
        showPopup(jQuery(this).attr("data-rel"));
    });

    /*- Fancy box -*/
    jQuery(".fancybox").fancybox({
        type: "iframe",
        padding: 0,
        fitToView: false,
        width: "100%",
        height: "100%",
        openEffect: "true",
        closeEffect: "true",
        autoplay: "true",
    });

    $.js = function (el) {
        return $("[data-js=" + el + "]");
    };


    for (let i = 1; i <= jQuery(".dacsac-swiper-large").length; i++) {
        new Swiper(".dacsac-swiper-large-" + i, {
            spaceBetween: 0,
            navigation: {
                nextEl: ".char-button-next",
                prevEl: ".char-button-prev",
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: true,
            },
            thumbs: {
                swiper: {
                    el: ".dacsac-swiper-nav-" + i,
                    navigation: {
                        nextEl: ".nav-button-next",
                        prevEl: ".nav-button-prev",
                    },
                    slidesPerView: 4,
                    spaceBetween: 0,
                    slidesPerColumn: 1,
                    slidesPerColumnFill: "row",
                    direction: "horizontal",
                    observer: true,
                    observeParents: true,
                },
            },
            observer: true,
            observeParents: true,
        });
    }

    /*---- Accordion Slider ---*/
    accordion.init({
        id: "accordion",
        autoPlay: false,
        itemWidth: 51,
        expandWidth: 440,
    });

    $(".default").mouseover()
});

function showPopup(object) {
    jQuery("body").append('<div class="bgover"></div>');
    // jQuery('.bgover').css({ 'width': widthWD, 'height': heightWD });
    jQuery("." + object)
        .addClass("active")
        .removeClass("hidden");
    jQuery(document).on("click", ".bgover,.popup-close", function (event) {
        event.preventDefault();
        jQuery(".bgover").remove();
        jQuery("." + object)
            .removeClass("active")
            .addClass("hidden");
    });
}

jQuery(window).on("load", function () {});
