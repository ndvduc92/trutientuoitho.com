@extends('layouts.auth')
@section('content')
<div class="main-content">
    <!-- Change Password Section -->
    <div class="account-section">
        <div class="account-section-title">
            Quên mật khẩu
        </div>

        <form id="password-form" method="POST" action="">
            @csrf
            <div class="form-group">
                <input type="" id="login" name="login" class="form-control" required="" placeholder="Tên tài khoản">
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" class="form-control" required="" placeholder="Email của tài khoản">
                <a class="form-info" href="/dang-nhap" style="color:blue">
                    <i class="fas fa-sign-in"></i> Quay lại đăng nhập
                </a>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Lấy mã OTP</button>
            </div>
        </form>
    </div>
</div>
@endsection