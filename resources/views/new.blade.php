@extends('layouts.app')
@section('content')
    <!-- News_Banner -->
    <section class="news_banner">
        <img class="img-fluid d-none d-lg-block" src="/assets/news_banner.jpg">
        <img class="img-fluid d-lg-none" src="/assets/news_banner_m.jpg">
    </section>
    <!-- News_list  -->
    <section class="latestnews">
        <div class="main-content">
            @include('layouts.newsheader')
            <div class="StaticMain" style="font-size: 16px">
                <div class="BlockTitle">
                    <h3 style="color: white; text-transform:uppercase">{!! $post->title !!}</h3>
                </div>
                <div class="ContentBlock" style="color: white">
                    {!! $post->content !!}
                </div>
            </div>


        </div>
    </section>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .new-tintuc {
            border: 1px solid #007ac8;
            background: #007ac8;
        }

        .new-huongdan {
            border: 1px solid #28a745;
            background: #28a745;
        }

        .new-sukien {
            border: 1px solid #dc3545;
            background: #dc3545;
        }

        /*- news list -*/
        ul.news-list {
            margin: 0;
            font-size: 14px;
        }

        ul.news-list li {
            width: 100%;
            overflow: hidden;
            padding: 0 0 5px 0;
            margin: 0 0 5px 0;
            position: relative;
        }

        ul.news-list li:not(:last-child) {
            border-bottom: 1px solid #374a5c;
        }

        ul.news-list li.highlight .news-title {
            float: left;
            width: calc(100% - 105px);
            display: block;
            color: #dab979;
            font-family: "SF-Bold";
            font-size: 16px;
        }

        ul.news-list li.highlight .news-title:hover {
            color: #ac1b03;
        }

        ul.news-list li.highlight .news-title:hover .news-time {
            color: #ac1b03;
        }

        ul.news-list li.highlight .news-title .news-time {
            font-size: 14px;
            color: #dab979;
            padding-top: 2px;
        }

        ul.news-list li .news__thumb {
            float: left;
            margin: 2px 10px 0 1px;
            height: auto;
        }

        ul.news-list li .news-des {
            width: calc(100% - 105px);
            color: #9eabba;
            float: left;
            overflow: hidden;
            position: relative;
            line-height: 20px;
            max-height: 60px;
        }

        ul.news-list li .news-des:before {
            content: '...';
            position: absolute;
            right: 0;
            bottom: 0;
        }

        ul.news-list li .news-des:after {
            content: '';
            position: absolute;
            right: 0;
            width: 1em;
            height: 1em;
            margin-top: 0.2em;
            background: #1a2f41;
        }

        ul.news-list li .news-title {
            color: #9fabba;
            width: 100%;
        }

        ul.news-list li .news-title:hover,
        ul.news-list li .news-title:hover .news-time {
            color: #a18c5c;
        }

        ul.news-list li .news-title span {
            width: calc(100% - 90px);
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            display: block;
            white-space: nowrap;
        }

        ul.news-list li .news-time {
            color: #9fabba;
            position: absolute;
            right: 0;
            top: 0px;
            text-align: right;
        }

        .news-more {
            display: inline-block;
            color: #e3edf1;
            font-size: 15px;
            float: right;
            margin: 0px 0 0px 0;
            background: #696969;
            padding: 0 30px 0 10px;
            position: relative;
            line-height: 25px;
        }

        .news-more:after {
            position: absolute;
            top: -2px;
            right: 5px;
            content: '+';
            font-size: 30px;
            line-height: .8;
        }

        .news-more:hover {
            color: #ffcd56;
            background: #8a520b;
        }

        .nicescroll-rails {
            z-index: 10 !important;
        }

        .nicescroll-cursors {
            border: 1px transparent solid !important;
        }

        .main-content {
            width: 1176px;
            padding: 90px 100px 50px 80px;
            margin: 0 auto 50px;
            background: url(/assets/maincontent-top.jpg) no-repeat 0 0, url(/assets/maincontent-bottom.png) no-repeat 0 100%, url(/assets/maincontent-loop.png) repeat-y 0 89px;
            position: relative;
            z-index: 1;
        }

        .main-content .news-list li {
            padding: 0 0 10px 0;
            margin: 0 0 10px 0;
            border-bottom: dotted 1px #566879 !important;
        }

        .main-content .news-list .highlight .news-des {
            color: #9eabba;
            font-size: 16px;
        }

        .main-content .news-list .highlight .news-des:hover {
            color: #1682dc;
        }

        .main-content .news-list .highlight .news-title {
            color: #dab979;
            margin-bottom: 5px;
        }

        .main-content .news-list .highlight .news-title .news-time {
            color: #dab979;
        }

        .main-content .news-list .highlight .news-title:hover {
            color: #1682dc;
        }

        .main-content .news-list .highlight .news-title:hover .news-time {
            color: #1682dc;
        }

        .static {
            overflow: hidden;
            padding: 0;
            position: relative;
            margin: 0px 0px 50px;
            padding: 7px 0 0 0;
        }

        .static .icon-static {
            float: left;
            margin-right: 5px;
        }

        .static h2 {
            font-size: 16px;
            font-weight: bold;
            color: #9eabba;
            margin: 10px 0 2px 5px;
            text-transform: uppercase;
        }

        .breadcrumb--main {
            font-size: 14px;
            color: #9eabba;
        }

        .breadcrumb--main a {
            color: #9eabba;
            text-decoration: none;
        }

        .breadcrumb--main a:hover {
            color: #ffe594;
        }

        .relative {
            padding-top: 9px;
            text-align: center;
        }

        .relative-title a {
            display: block;
            position: relative;
            margin: 0 0 10px;
            padding: 10px;
            color: #fff;
            text-transform: uppercase;
            text-align: left;
            font-weight: bold;
            font-size: 18px;
            background: #3b6b95;
            background: -webkit-linear-gradient(legacy-direction(90deg), #3b6b95, #3b6b95);
            background: -webkit-gradient(linear, left top, right top, from(#3b6b95), to(#3b6b95));
            background: -webkit-linear-gradient(left, #3b6b95, #3b6b95);
            background: -o-linear-gradient(left, #3b6b95, #3b6b95);
            background: linear-gradient(90deg, #3b6b95, #3b6b95);
        }

        .relative-title a:before {
            font-size: 35px;
            content: "\002b";
            font-family: 'GlyphiconsHalflings';
            position: absolute;
            top: -3px;
            right: 15px;
        }

        .relative-title a:hover {
            color: #bcd7e3;
        }

        .relative ul.relative-list {
            list-style: none;
            text-align: left;
            padding: 5px 0px 0;
            margin: 0 0 0 20px;
        }

        .relative ul.relative-list li {
            list-style: none;
            border-bottom: 1px solid #9eabba;
            padding: 12px 0 10px 5px;
            margin-left: 0px;
            position: relative;
            list-style: none;
        }

        .relative ul.relative-list li:last-child {
            border-bottom: none;
        }

        .relative ul.relative-list li a {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -ms-flex-pack: justify;
            justify-content: space-between;
            color: #9eabba;
        }

        .relative ul.relative-list li a:hover {
            color: #dab979;
            text-decoration: none;
        }

        .relative ul.relative-list li a span {
            display: block;
            overflow: hidden;
            position: relative;
            line-height: 1.4em;
            max-height: 2.8em;
            padding-right: 20px;
        }

        .relative ul.relative-list li a span:before {
            content: '...';
            position: absolute;
            right: 0;
            bottom: 0;
        }

        .relative ul.relative-list li a span:after {
            content: '';
            position: absolute;
            right: 0;
            width: 1em;
            height: 1em;
            margin-top: 0.2em;
            background: #1b3042;
        }

        .relative ul.relative-list li .date {
            display: block;
            color: #9eabba;
            text-transform: inherit;
            text-align: inherit;
            font-weight: normal;
            font-size: 14px;
            text-align: center;
            padding-left: 40px;
            line-height: 21px;
        }

        .boxsearch {
            position: absolute;
            top: 50%;
            right: 0px;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            z-index: 2;
            background: #131c28;
            border: 1px solid #242538;
            -webkit-border-radius: 20px;
            border-radius: 20px;
            width: 180px;
        }

        .boxsearch .bgsearch {
            background: transparent;
            border: none;
            width: 90px;
            font-size: 14px;
            padding: 3px 9px;
            color: #9da3c0;
        }

        .boxsearch .btsearch {
            background: url(/assets/icon-search.png) no-repeat 0 0;
            width: 13px;
            height: 13px;
            display: block;
            position: absolute;
            top: 7px;
            right: 11px;
            border: none;
            text-indent: -9999px;
        }

        /* Paging */
        .paging {
            text-align: center;
            padding-bottom: 25px;
        }

        ul.page__list {
            padding: 20px 0 0 !important;
            text-align: center;
        }

        ul.page__list li {
            display: inline-block !important;
            padding: 0 2px !important;
            margin: 0 !important;
        }

        ul.page__list li a {
            color: #9eabba !important;
            text-decoration: none !important;
            font-size: 15px;
            border: 1px solid #9eabba;
            display: block;
            padding: 0 10px;
            line-height: 24px;
        }

        ul.page__list li a:hover {
            color: #1b3042 !important;
            background-color: #9eabba;
            border: 1px solid #9eabba;
        }

        ul.page__list li a.disable,
        ul.page__list li a:hover .disable {
            opacity: 0.6;
            cursor: default;
            background: none;
            border: 1px solid #636363;
            color: #636363 !important;
        }

        ul.page__list li.active a {
            color: #1b3042 !important;
            background-color: #9eabba;
            border: 1px solid #9eabba;
        }

        ul.page__list li.prev a,
        ul.page__list li.next a {
            display: inline-block;
            padding: 0 10px;
            vertical-align: middle;
            width: 26px;
            height: 26px;
            margin: -2px 0 0 0;
        }

        .StaticMain {
            margin: calc(1.28125rem + 0.375vw) 0;
            clear: both;
            text-align: justify;
            min-height: 930px;
            color: #9eabba;
            /* Text styles */
            /* END. Text styles */
            /* Image styles */
            /* Notice box */
            /* List styles */
        }

        @media (min-width: 1200px) {
            .StaticMain {
                margin: 1.5625rem 0;
            }
        }

        .StaticMain h3 {
            font-family: myFont;
            color: #9eabba;
            font-size: 3em;
            font-weight: bold;
            text-align: center;
            margin: 0px 0 30px 0;
        }

        .StaticMain a {
            color: #028edf;
            text-decoration: underline;
        }

        .StaticMain a:hover {
            color: #ea1d00;
            text-decoration: none;
        }

        .StaticMain p {
            margin: 0 0 10px;
        }

        .StaticMain ul {
            list-style: disc;
            padding: 0 0 0 0;
        }

        .StaticMain ul li {
            list-style: disc;
            padding: 0 0 0 0px;
            margin: 0 0 5px 20px;
        }

        .StaticMain ul li ul {
            list-style: circle;
            padding: 0 0 10px 0;
        }

        .StaticMain ol {
            margin: 0 0 20px;
            padding: 0 0 0 20px;
        }

        .StaticMain ol li {
            margin: 0 0 10px;
            list-style: decimal !important;
        }

        .StaticMain .AnchorLink {
            margin: 0px 30px 20px;
            overflow: hidden;
            list-style: none outside none;
        }

        .StaticMain .AnchorLink li {
            float: left;
            width: 49%;
            padding: 0 0 5px 1px;
            margin: 0 1% 0 0;
            list-style: none;
        }

        @media only screen and (max-width: 768px) {
            .StaticMain .AnchorLink li {
                width: 31%;
                margin-right: 2%;
            }
        }

        @media only screen and (max-width: 480px) {
            .StaticMain .AnchorLink li {
                width: 48%;
                margin-right: 2%;
            }
        }

        @media only screen and (max-width: 320px) {
            .StaticMain .AnchorLink li {
                width: 98%;
                margin-right: 2%;
            }
        }

        .StaticMain .AnchorLink li a {
            text-decoration: none;
            padding-left: 15px;
            font-weight: bold;
            position: relative;
            color: #028edf;
        }

        .StaticMain .AnchorLink li a:before {
            content: '';
            width: 8px;
            height: 8px;
            border: solid 1px #028edf;
            position: absolute;
            top: 6px;
            left: 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .StaticMain .AnchorLink li a.Active,
        .StaticMain .AnchorLink li a.Active:hover,
        .StaticMain .AnchorLink li a:hover {
            color: #ea1d00;
        }

        .StaticMain .AnchorLink li a.Active:before,
        .StaticMain .AnchorLink li a.Active:hover:before,
        .StaticMain .AnchorLink li a:hover:before {
            content: '';
            position: absolute;
            top: 6px;
            left: 0;
            background: #ea1d00;
            border: solid 1px #ea1d00;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
            color: #055bcd;
        }

        .StaticMain .FirstChar {
            padding: 4px 4px 0 0;
            line-height: 30px;
            font-size: 42px;
            font-weight: bold;
            float: left;
            color: #9eabba;
        }

        .StaticMain .ContentBlock {
            padding-bottom: 20px;
            clear: both;
        }

        .StaticMain .ImagesBlock {
            text-align: center;
            margin-bottom: 20px;
        }

        .StaticMain .ImgCenter {
            text-align: center !important;
            margin-bottom: 20px !important;
            font-size: 90%;
            font-style: italic;
        }

        .StaticMain h4 {
            color: #ea1d00;
            padding: 10px 0 10px 50px;
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 5px 0px;
            background: url("../images/content/icon-h4.png") no-repeat;
        }

        .StaticMain .ContentH4 {
            clear: both;
            margin: 0 0 10px 50px;
            padding: 0 0 0 0px;
        }

        .StaticMain .ContentH4 p {
            margin-bottom: 10px;
            /*text-align: justify;*/
        }

        .StaticMain .ImagesH4 {
            text-align: center;
            margin: 0 0 20px 50px;
        }

        .StaticMain h5 {
            color: #ea1d00;
            padding: 10px 0 10px 40px;
            margin: 0 0 10px 50px;
            font-size: 18px;
            font-weight: bold;
            background: url("../images/content/icon-h5.png") no-repeat 0 0px;
        }

        .StaticMain .ContentH5 {
            clear: both;
            margin: 0 0 0 90px;
            padding: 0 0 20px;
        }

        .StaticMain .ContentH5 p {
            margin-bottom: 10px;
            text-align: justify;
        }

        .StaticMain .ImagesH5 {
            text-align: center;
            margin: 0 0 20px 40px;
        }

        .StaticMain table {
            border-top: solid 1px #1f002b;
            margin: 0 auto 20px;
            border-collapse: collapse;
        }

        .StaticMain table thead tr th {
            color: #eef9f9;
            background: #3b6b95;
            font-weight: bolder;
            padding: 10px 10px;
            border-right: 1px solid #1f002b;
            border-left: 1px solid #1f002b;
            border-bottom: 1px solid #1f002b;
            text-align: center;
        }

        .StaticMain table tbody tr:nth-child(odd) {
            background-color: #c5d1db;
        }

        .StaticMain table tbody tr:nth-child(even) {
            background-color: #e8eef3;
        }

        .StaticMain table tbody tr td {
            padding: 10px 10px;
            border: 1px solid #1f002b;
            border-top: none;
            color: #1a222a;
        }

        .StaticMain table tbody tr td a {
            color: #1a222a;
        }

        .StaticMain table tbody tr td a:hover {
            color: #055bcd;
        }

        .StaticMain table.Notice {
            border: 1px solid #1f002b;
        }

        .StaticMain table.Notice tr td {
            padding: 10px 20px;
            border: 1px solid #1f002b;
        }

        .StaticMain table.Notice tr td p {
            margin-bottom: 10px;
        }

        .StaticMain table.Notice tr td ul,
        .StaticMain table.Notice tr td ol {
            padding-bottom: 0px;
            margin-bottom: 0px;
        }

        .StaticMain .TextCenter {
            text-align: center;
        }

        .StaticMain .TextRight {
            text-align: right;
        }

        .StaticMain .Strong01 {
            font-weight: bolder;
            color: #dab979;
        }

        .StaticMain .Strong02 {
            font-weight: bolder;
            color: #ea1d00;
        }

        .StaticMain .Strong03 {
            font-weight: bolder;
            color: #006cc8;
        }

        .StaticMain .TextFont17 {
            font-size: 17px;
        }

        .StaticMain .TextFont19 {
            font-size: 19px;
        }

        .StaticMain .TextFont21 {
            font-size: 21px;
        }

        .StaticMain .NoBorderImg {
            border: none;
            background: none;
            padding: 0;
        }

        .StaticMain .BorderImg {
            background: #000;
            border: 1px solid #000;
            padding: 0px;
        }

        .StaticMain .ImgLeft {
            float: left;
            margin: 1px 10px 5px 0;
            border: 1px solid #000;
        }

        .StaticMain .ImgRight {
            float: right;
            margin: 0 0 5px 10px;
            border: 1px solid #000;
        }

        .StaticMain blockquote {
            border-left: 2px solid #1f002b;
            font-size: 14px;
            margin: 0 20px;
            padding: 10px 40px;
            margin: 0;
            position: relative;
            font-style: italic;
        }

        .StaticMain blockquote:before,
        .StaticMain blockquote:after {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            content: '';
        }

        .StaticMain blockquote:before {
            top: 0;
            left: 10px;
            background-position: 0 0;
        }

        .StaticMain blockquote:after {
            right: 0;
            bottom: 0;
            background-position: -20px 0;
        }

        .StaticMain .NoticeBox {
            border: solid 1px #8d8d8d;
            padding: 10px;
            background: #e8eef3;
        }

        .StaticMain .NoticeBox p.Legend {
            font-size: 13px;
            font-weight: bolder;
            padding: 0 15px;
            color: #fff;
            background: #af2e23;
            height: 20px;
            margin: -20px 0 10px;
            float: left;
            border: solid 1px #af2e23;
        }

        .StaticMain .NoticeBox .NoteContent {
            width: 100%;
            overflow: hidden;
            text-align: justify;
            color: #1e2c19;
        }

        .StaticMain .NoticeBox .NoteContent a {
            color: #1c76fd;
        }

        .StaticMain .NoticeBox .NoteContent a:hover {
            color: #fd4b36;
        }

        .StaticMain ul.Decimal {
            margin: 0px 0px 10px 0px;
        }

        .StaticMain ul.Decimal li {
            list-style-type: decimal;
            margin-bottom: 10px;
            text-align: justify;
        }

        .StaticMain ul.Decimal li ul {
            padding-top: 5px;
        }

        .StaticMain ul.UpperAlpha {
            margin: 0px 0px 10px 0px;
        }

        .StaticMain ul.UpperAlpha li {
            list-style-type: upper-alpha;
            margin-bottom: 10px;
            text-align: justify;
        }

        .StaticMain ul.UpperAlpha li ul {
            padding-top: 5px;
        }

        .StaticMain ul.LowerAlpha {
            margin: 0px 0px 10px 0px;
        }

        .StaticMain ul.LowerAlpha li {
            list-style-type: lower-alpha;
            margin-bottom: 10px;
            text-align: justify;
        }

        .StaticMain ul.LowerAlpha li ul {
            padding-top: 5px;
        }

        .StaticMain ul.Icon {
            margin: 0px 0px 10px 5px;
        }

        .StaticMain ul.Icon li {
            margin-bottom: 10px;
            padding-left: 15px;
            list-style-type: none;
            text-align: justify;
            position: relative;
        }

        .StaticMain ul.Icon li:before {
            font-size: 8px;
            content: "\e074";
            font-family: 'GlyphiconsHalflings';
            position: absolute;
            top: 4px;
            left: 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .StaticMain ul.Icon li ul {
            padding-top: 5px;
        }

        .StaticMain ul.Icon li ul.LowerAlpha li {
            list-style-type: lower-alpha;
            margin-bottom: 10px;
            background: none;
            padding-left: 0px;
        }

        .StaticMain ul.Dash {
            margin: 0px 0px 10px 5px;
        }

        .StaticMain ul.Dash li {
            margin-bottom: 10px;
            padding-left: 15px;
            list-style-type: none;
            text-align: justify;
            position: relative;
        }

        .StaticMain ul.Dash li:before {
            font-size: 8px;
            content: "\2212";
            font-family: 'GlyphiconsHalflings';
            position: absolute;
            top: 5px;
            left: 0;
        }

        .StaticMain ul.Dash li ul {
            padding-top: 5px;
        }

        .StaticMain ul.Disc {
            margin: 0px 0px 10px 5px;
        }

        .StaticMain ul.Disc li {
            list-style-type: none;
            margin: 0 0 10px 0;
            padding: 0 0 0 15px;
            text-align: justify;
            position: relative;
        }

        .StaticMain ul.Disc li:before {
            font-size: 8px;
            content: "\e165";
            font-family: 'GlyphiconsHalflings';
            position: absolute;
            top: 5px;
            left: 0;
        }

        .StaticMain ul.Disc li ul {
            padding-top: 5px;
        }
    </style>
@endsection
