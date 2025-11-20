<div class="header-info-box">
    <span><i class="align-middle me-1" data-feather="user"></i><strong>TÀI KHOẢN:</strong> {{Auth::user()->username}}</span>
    <span><i class="align-middle me-2 fas fa-fw fa-coins"></i><strong>XU NẠP:</strong>
        {{number_format(Auth::user()->balance)}}</span>
    <span><i class="align-middle me-2 fas fa-fw fa-user-ninja"></i><strong>Player</strong></span>
    <span>@include('account.layouts.chars')</span>
</div>