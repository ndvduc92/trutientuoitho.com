@extends('layouts.master')

@section('content')
<style>
    .chat-item {
        margin: 5px 0;
        padding: 5px;
        font-size: 14px
    }
</style>
<style>
    .chars-list {
        display: none
    }

    .vs {
        font-size: 8px;
    }
</style>

<style>
.notice-box {
  background: linear-gradient(to right, #fff3cd, #ffeeba);
  border-left: 5px solid #ffc107;
  color: #856404;
  padding: 12px 16px;
  margin: 20px 0;
  font-size: 16px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  animation: pulseNotice 1.5s infinite ease-in-out;
}

@keyframes pulseNotice {
  0%   { box-shadow: 0 0 0 rgba(255, 193, 7, 0.4); }
  50%  { box-shadow: 0 0 12px rgba(255, 193, 7, 0.8); }
  100% { box-shadow: 0 0 0 rgba(255, 193, 7, 0.4); }
}
</style>
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-gem"></i> Chat vào game
    </div>
    @if(!request()->gm)
    <form id="contact-form" action="" method="post">
        @csrf
        <div class="form-group">
                <input type="" name="msg" class="form-control" required="" placeholder="Nhập lời nhắn">
                <div class="form-info">
                    <i class="fas fa-info-circle"></i> Chat với mọi người trong game thông qua web
                </div>
            </div>

        <div class="">
            <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
        </div>
    </form>
    @endif
</div>
<div class="account-section" style="background: rgba(0, 0, 0, 0.5);">
    <a href="" class="account-section-title">
        <i class="fas fa-comment"></i> Phi cáp truyền thư
    </a>
    <div class="notice-box">
        🔔 <strong>Lưu ý:</strong> Vip 6 trở lên có quyền xem <strong>full chat</strong>: Nói thầm - Gia tộc - Bang Hội (của nhân vật)
    </div>
    <div class="chat" style="max-height: 800px;overflow: auto;">
        @foreach ($chs as $ch)
        @php
        $vip = $ch["vip"];
        $vipIcon = $vip > 0 ? "<span class='vip lvl{$vip}'></span>" : "";
        @endphp
        <div class="chat-item"> {{ $ch['date'] }} <span style="color: {{ $ch['color'] }}"
                class="px-4 py-2 rounded-lg inline-block rounded-bl-none">
                [{{ $ch['from'] }}]<strong style="color: #abb794">{!! $ch['from'] == "Nói Thầm" ?
                    ($ch['name']). " 💬 " . ($ch['dest_name']) : ($ch['name']) !!}</strong>:
                {{ $ch['msg'] }}
            </span>
        </div>
        @endforeach
    </div>
</div>
@endsection