@extends('layouts.auth')
@section('content')

    <div class="main-content">
        <div class="account-section">
            <div class="account-section-title">
                ĐĂNG NHẬP
            </div>

            <form method="POST" action="" id="password-form">
                @csrf
                <div class="form-group">
                    <input type="" id="current_password" name="login" class="form-control"
                        required="" placeholder="Tên đăng nhập">
                </div>
                <div class="form-group">
                    <input type="password" id="current_password" name="password" class="form-control"
                        required="" placeholder="Mật khẩu">
                    <a class="form-info" href="/quen-mat-khau">
                        <i class="fas fa-warning"></i> Không nhớ mật khẩu?
                    </a>
                    <a class="form-info" href="/dang-ky" style="color:blue">
                        <i class="fas fa-sign-in"></i> Chưa có tài khoản, ĐĂNG KÝ
                    </a>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">ĐĂNG NHẬP</button>
                </div>
            </form>
        </div>
    </div>
@endsection
