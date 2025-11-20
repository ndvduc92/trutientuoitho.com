@extends('layouts.app')
@section('content')
<section class="news_banner">
    <img class="img-fluid d-none d-lg-block" src="/assets/news_banner.jpg">
    <img class="img-fluid d-lg-none" src="/assets/news_banner_m.jpg">
</section>
<div class="eventx">
    <div style="margin-bottom: 144px">
        @include('layouts.event')
    </div>

    @include('layouts.info')
</div>
<style>
    body {
        background: url(/assets/bg-blue-1.webp) no-repeat bottom center;
    }
</style>
@endsection