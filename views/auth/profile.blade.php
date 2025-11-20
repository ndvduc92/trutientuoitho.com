@extends('layouts.master')
@section('content')
<style>
  .alert-message {
    background-color: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    padding: 10px 15px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    display: none;
  }

  .alert-message i {
    font-size: 1.2rem;
    margin-right: 10px;
  }

  .alert-message.success {
    border-color: #2ecc71;
    color: #2ecc71;
  }

  .alert-message.error {
    border-color: #e74c3c;
    color: #e74c3c;
  }

  .copy-btn {
    margin-left: 10px;
    padding: 4px 8px;
    font-size: 12px;
    border: none;
    border-radius: 6px;
    background: #1baac2;
    color: #fff;
    cursor: pointer;
    transition: background 0.2s;
  }

  .copy-btn:hover {
    background: #14889c;
  }

  .notice-box {
    background: linear-gradient(to right, #fff3cd, #ffeeba);
    color: #856404;
    padding: 12px 16px;
    margin: 20px 0;
    font-size: 16px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }
</style>
<div class="main-content">
  <!-- Account Overview Section -->

  <div class="account-section">
    <div class="account-section-title">
      <i class="fas fa-id-card"></i> Thông Tin Tài Khoản
    </div>
    <div class="notice-box">
      <span class="online-indicator"></span>Fanpage cũ đã bị hack, các bạn chuyển qua page mới giúp mình nhé <a href="https://www.facebook.com/trutienvn2025/">Link fanpage<span
          class="badge-new">Mới</span></a>
    </div>
    <div class="account-detail">
      <div class="account-detail-label">ID Tài khoản:</div>
      <div class="account-detail-value">
        <span id="account-id">{{ Auth::user()->userid }} </span>
        <button id="copy-btn" class="copy-btn">📋 Copy</button>
      </div>
    </div>

    <div class="account-detail">
      <div class="account-detail-label">Tên tài khoản:</div>
      <div class="account-detail-value">
        <span id="account-username">{{ Auth::user()->username }}</span>
        <button id="copy-btn-username" class="copy-btn">📋 Copy</button>
      </div>
    </div>

    <div class="account-detail">
      <div class="account-detail-label">Xu nạp:</div>
      <div class="account-detail-value">
        {{ number_format(Auth::user()->balance) }}
      </div>
    </div>
    <div class="account-detail">
      <div class="account-detail-label">Xu event:</div>
      <div class="account-detail-value">
        {{ number_format(Auth::user()->xu_event - Auth::user()->xu_event_used) }}
      </div>
    </div>
    <div class="account-detail">
      <div class="account-detail-label">Xu war:</div>
      <div class="account-detail-value">
        {{ number_format(Auth::user()->war_point - Auth::user()->war_point_used) }}
      </div>
    </div>

    <div class="account-detail">
      <div class="account-detail-label">Cấp VIP:</div>
      <div class="account-detail-value">
        {{(Auth::user()->viplevel)}}
      </div>
    </div>

    <div class="account-detail">
      <div class="account-detail-label">Mật khẩu:</div>
      <div class="account-detail-value">
        **********<a class="" style="color:red" href="/doi-mat-khau"><span role="button">[Thay đổi]</span></a>
      </div>
    </div>

    <div class="account-detail">
      <div class="account-detail-label">Email:</div>
      <div class="account-detail-value">
        {{ Auth::user()->email2 }} <a class="" style="color:red" href="/doi-email"><span role="button">[Thay
            đổi]</span></a>
      </div>
    </div>

    {{-- <div class="account-detail">
      <div class="account-detail-label">Chọn nhân vật chính:</div>
      <div class="account-detail-value">
        <div class="character-dropdown">
          <select id="Sel_Role" style="border: 1px solid #17a2b8;">
            <option value="">---Chọn nhân vật---</option>
            @foreach (Auth::user()->chars() as $item)
            <option {{Auth::user()->main_id == $item->char_id ? 'selected' : ''}} value="{{ $item->char_id }}">{!!
              $item->class_icon !!} {{ $item->getName() }} [{{ $item->char_id }}]</option>
            @endforeach
            <option value="Không thấy nhân vật?">Cập nhật nhân vật?</option>
          </select>
        </div>
      </div>
    </div> --}}


  </div>

  @include('auth.chars')
</div>
<script>
  document.getElementById("copy-btn").addEventListener("click", function () {
    const accountId = document.getElementById("account-id").innerText;

    navigator.clipboard.writeText(accountId).then(() => {
      alert("Đã copy ID: " + accountId);
    }).catch(err => {
      console.error("Copy thất bại", err);
    });
  });

  document.getElementById("copy-btn-username").addEventListener("click", function () {
    const accountId = document.getElementById("account-username").innerText;

    navigator.clipboard.writeText(accountId).then(() => {
      alert("Đã copy Tên tài khoản: " + accountId);
    }).catch(err => {
      console.error("Copy thất bại", err);
    });
  });
</script>
@endsection