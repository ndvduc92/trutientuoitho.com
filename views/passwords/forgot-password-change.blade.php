@extends('layouts.auth')
@section('content')
<div class="main-content">
    <!-- Change Password Section -->
    <div class="account-section">
        <div class="account-section-title">
            LẤY LẠI MẬT KHẨU
        </div>

        <form id="password-form" method="POST" action="">
            @csrf
            <div class="form-group">
                <input type="password" id="passwd" name="new" class="form-control" required="" placeholder="Mật khẩu mới">
            </div>

            <div class="form-group">
                <input type="password" id="email" name="newcf" class="form-control" required="" placeholder="Nhập lại mật khẩu mới">
            </div>
            <div class="form-group">
                <input type="" id="otp" name="otp" class="form-control" required="" placeholder="Mã OTP">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
            </div>
        </form>
    </div>
</div>
@endsection