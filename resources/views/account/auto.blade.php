@extends('layouts.master')
@section('content')
<style>
    li a {
        display: inline;
    }
</style>
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-rotate"></i> Hướng dẫn auto đổi đồ
    </div>

    <div class="security-tips">
        <div class="security-tips-header" style="color: black">
            <i class="fas fa-download"></i> Link tải
        </div>
        <ul style="width: 100%;">
            <li>Auto Hot Key: <a href="https://www.autohotkey.com/download/ahk-install.exe" target="_blank" style="color:blue">Tải về</a></li>
            </li>
            <li>
                Script đổi đồ: <a href="https://trutiendailuc.com/HA.ahk" target="_blank" style="color:blue">Tải về</a>
            </li>
        </ul>
    </div>
</div>
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-video"></i> Video hướng dẫn</span>
    </div>

    <video width="100%" height="auto" controls>
        <source src="https://trutiendailuc.com/wiki.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

</div>
@endsection