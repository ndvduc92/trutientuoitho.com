@extends('account.layouts.auth')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="m-sm-3">
            <form method="POST" action="">
                @csrf
                <div class="mb-3">
                    <input required class="form-control form-control-lg" type="text" name="login"
                        placeholder="Tên đăng nhập" />
                </div>
                <div class="mb-3">
                    <input required class="form-control form-control-lg" type="password" name="password"
                        placeholder="Nhập mật khẩu" />
                </div>
                <div class="mb-3">
                    <a class="form-info" href="/account/quen-mat-khau">
                        <i class="fas fa-warning"></i> Không nhớ mật khẩu?
                    </a>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-lg btn-success">Đăng Nhập</button>
                </div>
            </form>

        </div>
        <div class="text-center mb-3">
            Chưa có tài khoản? <a href="/account/dang-ky">Đăng Ký</a>
        </div>
    </div>
</div>
@endsection