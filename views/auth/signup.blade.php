@extends('layouts.auth')
@section('content')
<style>

    ul {
        width: 100% !important;
    }
</style>
<div class="main-content">
    <!-- Change Password Section -->
    <div class="account-section">
        <div class="account-section-title">
            ĐĂNG KÝ TÀI KHOẢN
        </div>

        <form id="password-form" method="POST" action="">
            @csrf
            <div class="form-group">
                <input type="" id="login" name="login" class="form-control" required="" placeholder="Tên đăng nhập">
            </div>
            <div class="form-group">
                <input type="password" id="passwd" name="passwd" class="form-control" required=""
                    placeholder="Mật khẩu">

            </div>
            <div class="form-group">
                <input type="password" id="passwdConfirm" name="passwdConfirm" class="form-control" required=""
                    placeholder="Nhập lại mật khẩu">

            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" class="form-control" required="" placeholder="Email">
                <a class="form-info" href="/quen-mat-khau">
                    <i class="fas fa-warning"></i> Lưu ý: dùng email thật để có thể lấy lại mật khẩu khi quên
                </a>
            </div>
            <div id="captcha" class="py-2 flex" style="margin-bottom: 10px;">
                {!! captcha_img() !!}
            </div>
            <div class="form-group">
                <input type="" id="captcha" name="captcha" class="form-control" required="" placeholder="Mã xác nhận">
                <a class="form-info" href="/dang-nhap" style="color:blue">
                    <i class="fas fa-sign-in"></i> Đã có tài khoản, ĐĂNG NHẬP
                </a>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">ĐĂNG ký</button>
            </div>
        </form>
    </div>
</div>
@endsection