@extends('layouts.master')
@section('content')
@include('layouts.accounts')

<style>
  .form-actions {
    display: flex;
    justify-content: center !important;
    gap: 15px;
    margin-top: 30px;
  }
</style>
<div class="account-section">
  <a href="" class="account-section-title">
    <i class="fa-solid fa-briefcase"></i> Quản lý Tài khoản phụ
  </a>
  <div class="security-tips">
    <div class="security-tips-header">
      <i class="fas fa-shield-alt"></i> Lưu ý
    </div>
    <ul style="width: 100%;">
      <li>Thêm tài khoản phụ để tiện lợi hơn trong việc quản lý</li>
      <li>Có thể đăng nhập nhanh tài khoản phụ từ menu</li>
      <li>Chỉ cần nhập đúng tên tài khoản và mật khẩu của tài khoản phụ để xác thực là có thể liên kết
        thành công</li>
      <li>Chỉ tài khoản chính mới được quyền thêm tài khoản phụ</li>
    </ul>
  </div>
  @if(count(meta()) > 1)
  <div class="security-tips">
    <div class="security-tips-header">
      <i class="fas fa-shield-alt"></i> Danh sách tài khoản phụ
    </div>
    <table id="killers-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tên đăng nhập</th>
          <th>Email</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach (meta() as $user)
        <tr>
          <td class="player-name">TT_{{ ($user->userid) }}</td>
          <td class="rank-column top-rank">{{ ($user->username) }}</td>
          <td>{{ ($user->username) }}</td>
          <td>@if (!isMainMeta($user->id))
            <a href="/meta/{{ ($user->id) }}/delete" class="">Xoá</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
  <div style="margin-top:50px">
    <div class="p-2 dark:text-primary-light border-b dark:border-primary-light">
      <h4 class="text-2xl font-semibold ">Thêm mới tài khoản phụ</h4>
    </div>
    <form method="POST" action="" class="p-2">
      @csrf
      <div class="form-group">
        <label for="current_password">Tên đăng nhập:</label>
        <input type="" id="current_password" name="username" class="form-control" required="">
      </div>
      <div class="form-group">
        <label for="current_password">Mật khẩu:</label>
        <input type="password" id="current_password" name="password" class="form-control" required="">
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
      </div>
    </form>


  </div>
</div>
@endsection