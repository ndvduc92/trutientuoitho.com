@extends('account.layouts.auth')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="m-sm-3">
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <input required class="form-control form-control-lg" type="text" name="login" placeholder="Tên đăng nhập" />
                </div>
                <div class="mb-3">
                    <input required class="form-control form-control-lg" type="password" name="passwd"
                        placeholder="Nhập mật khẩu" />
                </div>
                <div class="mb-3">
                    <input required class="form-control form-control-lg" type="password" name="passwdConfirm"
                        placeholder="Nhập lại mật khẩu" />
                </div>
                <div class="mb-3">
                    <input required class="form-control form-control-lg" type="email" name="email"
                        placeholder="Nhập email của bạn" />
                </div>
                <div id="captcha" class="py-2 flex" style="margin-bottom: 10px;">
                    {!! captcha_img() !!}
                </div>
                <div class="mb-3">
                    <input required class="form-control form-control-lg" type="" name="captcha" placeholder="Mã xác nhận" />
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-success">Đăng Ký</button>
                </div>
            </form>

        </div>
        <div class="text-center mb-3">
            Đã có tài khoản? <a href="/account/dang-nhap">Đăng Nhập</a>
        </div>
    </div>
</div>
@endsection