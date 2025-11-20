@extends('layouts.master')
@section('content')
<style>
    .content_mine {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: calc(var(--spacing-multiplier) * 4);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
    }


    /* Countdown timer */
    .content_mine .countdown {
        font-weight: bold;
        font-size: 16px;
        color: var(--primary-color);
        margin-bottom: calc(var(--spacing-multiplier) * 2);
    }

    /* Form styles */
    .mine-form {
        display: flex;
        justify-content: center;
        margin-top: calc(var(--spacing-multiplier) * 2);
    }

    /* Button image styling */
    button#mine-button img {
        width: 120px;
        height: auto;
        transition: transform 0.3s ease;
    }

    /* Button hover effect */
    button#mine-button img:hover {
        transform: scale(1.05);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .content_mine {
            padding: calc(var(--spacing-multiplier) * 3);
            max-width: 100%;
        }

        .content_mine img {
            width: 120px;
            /* Smaller image size on mobile */
        }

        button#mine-button img {
            width: 80px;
            /* Smaller button size on mobile */
        }
    }
</style>
<style>
    #afk-timer {
        text-align: center;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 22px;
        color: #ffe066;
        /* vàng dịu */
        background: rgba(0, 0, 0, 0.4);
        display: inline-block;
        padding: 10px 20px;
        border: 2px solid #ffe066;
        border-radius: 12px;
        box-shadow: 0 0 15px #ffe06666;
    }

    #afk-time {
        font-weight: bold;
        font-size: 26px;
        color: #00ffe0;
        /* xanh ngọc */
        margin-left: 10px;
        letter-spacing: 1px;
    }
</style>

<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-rotate"></i> Treo máy offline ({{$total + 10}} người đang treo)
    </div>

    <div class="security-tips">
        <div class="security-tips-header">
            <i class="fas fa-shield-alt"></i> Một số lưu ý
        </div>
        <ul style="width: 100%;">
            <li>Treo máy cho nhân vật <font color="red">{{ Auth::user()->char->getName() }}
                    ({{Auth::user()->char->char_id}})</font>
            </li>
            <li>
                Tính năng hỗ trợ treo máy offline, giúp nhân vật của bạn vẫn có thể nhận tài nguyên trong khi không
                online.
            </li>
            <li>Hỗ trợ cho những bạn bận off không treo máy được</li>
            <li>Duy trì số dư ít nhất 100.000 xu sẽ được treo máy (miễn phí)</li>
            <li>Việc treo máy offline sẽ dừng ngay lập tức khi nhân vật online trở lại</li>
            <li style="color:red">Xu treo máy sẽ được dùng để trao đổi trong shop item xu web trong game</li>
        </ul>
    </div>
    <br>
    <div class="content_mine" style="max-width: 800px; margin: 0 auto;">
        <h3>
            Côn Luân - Khai Thác Linh Thạch
        </h3>
        <div id="afk-timer">
            Thời gian treo máy: <span id="afk-time">00:00:00</span>
        </div>
        <img style="width: 100%; max-width: 400px" src="https://tutiengioi.online/images/icon/linh_son.png" alt="">
        <form id="mine-form" class="mine-form" action="" method="POST">
            @csrf
            <input type="hidden" value="497" name="userId">
            <br>
            <br>
            @if (!$session)
            <button type="submit" id="mine-button" class="btn btn-primary" style="font-weight: bold; margin-top: 20px;">
                Khai Thác Linh Thạch
            </button>
            @else
            <button type="submit" id="mine-button" class="btn btn-primary" style="font-weight: bold; margin-top: 20px;">
                <i class="fas fa-lock"></i> Dừng khai thác
            </button>
            @endif
        </form>
        <div class="guide-section" style="margin-top: 20px; text-align: center;">
            <h3>TÀI NGUYÊN NHẬN ĐƯỢC</h3>
            <style>
                .item {
                    display: flex;
                    align-items: center;
                    margin-bottom: 8px;
                    /* khoảng cách giữa các dòng */
                }

                .item img {
                    width: 32px;
                    /* chỉnh theo kích thước icon thực tế */
                    height: 32px;
                    margin-right: 8px;
                    /* khoảng cách giữa icon và chữ */
                }

                .item span {
                    font-size: 16px;
                    /* chỉnh font-size phù hợp */
                    color: #fff;
                    /* hoặc màu chữ bạn muốn */
                    line-height: 1.2;
                    /* line-height vừa phải */
                }
            </style>
            @foreach (\App\Models\OfflineSession::DROP_RATES as $item)
            <div class="item">
                <img src="https://items.trutienvietnam.com/icons/{{$item['item_id']}}.png" alt="Icon">
                <span>{{$item['item_name']}} (tỉ lệ {{$item['drop_rate_per_minute']*100}}% rớt ngẫu nhiên
                    {{$item['min_quantity']}} - {{$item['max_quantity']}} / phút)</span>
            </div>
            @endforeach
        </div>

    </div>

    {{-- <form id="contact-form" action="" method="post" style="margin-top: 20px;">
        @csrf
        <div class="form-group character-dropdown">
            <select name="class" id="coin_type" class="form-control" style="padding: 12px 15px;" required>
                @foreach (\App\Models\Char::CLASS_ITEM as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary">Đổi môn phái</button>
        </div>
    </form> --}}
</div>
@if ($session)
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const timerElement = document.getElementById('afk-time');
    const afkContainer = document.getElementById('afk-timer');

    const startTime = new Date("{{$session->start_time}}").getTime();

    function pad(num) {
      return num.toString().padStart(2, '0');
    }

    function updateTimer() {
      const now = new Date().getTime();
      let diff = Math.floor((now - startTime) / 1000);

      const hours = Math.floor(diff / 3600);
      diff = diff % 3600;
      const minutes = Math.floor(diff / 60);
      const seconds = diff % 60;

      timerElement.textContent = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
    }

    updateTimer();
    setInterval(updateTimer, 1000);
  });
</script>
@endif
@endsection