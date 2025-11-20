@extends('layouts.app')
@section('content')
@include('layouts.menu')
<style>
    body {
        background: url(/assets/bg.jpg) no-repeat bottom center;
    }
</style>

<!-- Header -->
@include('layouts.video')
<!-- Main -->
@include('layouts.reward')
@include('layouts.new2')

@include('layouts.class')
{{-- @include('layouts.dacsac')
@include('layouts.screen') --}}

@include('layouts.features')

<!-- GameInfo -->
@include('layouts.info')
<!-- Popup -->
@endsection

@section('script')
<script>
    function activeBtn(x) {
            x.setAttribute("src", "/assets/taigame-btn-active.png");
        }

        function normalBtn(x) {
            x.setAttribute("src", "/assets/taigame-btn.png");
        }
</script>
@endsection