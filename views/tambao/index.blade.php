@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="/static/shake.css">
@include('tambao.modal')
<style>
    .chest-container h2 {
        color: #333;
        margin-bottom: 15px;
    }

    .chest-box {
        position: relative;
        background: linear-gradient(to bottom, #ffcc66, #cc9933);
        border: 4px solid #996600;
        border-radius: 12px;
        width: 270px;
        height: 210px;
        margin: 40px auto;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: transform 0.2s;
    }

    .chest-box::before {
        content: "";
        position: absolute;
        top: -30px;
        left: 0;
        right: 0;
        margin: auto;
        width: 160px;
        height: 40px;
        background: linear-gradient(to bottom, #ffdd88, #cc9933);
        border: 4px solid #996600;
        border-radius: 8px 8px 0 0;
    }

    .chest-box.opened {
        background: linear-gradient(to bottom, #ffeeaa, #cc9933);
        animation: chestShake 0.5s ease;
    }

    @keyframes chestShake {
        0% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(3deg);
        }

        50% {
            transform: rotate(-3deg);
        }

        75% {
            transform: rotate(2deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .open-btn {
        background: #ff6f61;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .open-btn:hover {
        background: #e85b50;
    }

    .reward {
        font-size: 20px;
        font-weight: bold;
        margin-top: 50px;
        color: #333;
        min-height: 40px;
    }

    .reward-popup {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 28px;
        font-weight: bold;
        animation: floatUp 1.5s ease forwards;
        pointer-events: none;
    }

    .chest-actions {
        margin-top: 15px;
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .chest-btn {
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chest-btn.free {
        background: #ff6f61;
        color: #fff;
    }

    .chest-btn.buy {
        background: #4caf50;
        color: #fff;
    }

    .open-btn {
  background: linear-gradient(135deg, #f7d774, #d4af37);
  color: #2c1a00;
  font-size: 1.2rem;
  font-weight: bold;
  padding: 14px 40px;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  box-shadow: 0 6px 20px rgba(212, 175, 55, 0.5);
  transition: all 0.3s ease;
  margin-top: 20px;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

.open-btn:hover {
  background: linear-gradient(135deg, #ffe58f, #e1b23c);
  box-shadow: 0 8px 25px rgba(255, 215, 0, 0.7);
  transform: translateY(-2px) scale(1.05);
}

.open-btn:active {
  transform: translateY(1px) scale(0.98);
  box-shadow: 0 3px 10px rgba(212, 175, 55, 0.4);
}


    .chest-btn.open {
        background: #2196f3;
        color: #fff;
    }

    .chest-btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }


    @keyframes floatUp {
        0% {
            opacity: 0;
            transform: translate(-50%, 0);
        }

        30% {
            opacity: 1;
            transform: translate(-50%, -30px);
        }

        100% {
            opacity: 0;
            transform: translate(-50%, -80px);
        }
    }
</style>
<div class="account-section">
    <div class="account-section-title">
        Rương May Mắn
    </div>
    <div class="chest-container">
        <h2>💎 Mở Rương May Mắn</h2>
        <div class="chest-box" id="chest"></div>
        <button class="open-btn" id="openBtn">Mở Rương</button>
        <div class="reward" id="reward"></div>
    </div>

    <div class="chest-actions">
        <button class="chest-btn free">🎁 Mở miễn phí (<span
                id="numFree">{{$wheel->usedTimes("free")}}</span>/3)</button>
        <button class="chest-btn open">📦 Thêm lượt (<span id="numPlus">{{$wheel->usedTimes("plus")}}</span>/{{$plus}})</button>
        <button class="chest-btn buy" id="btnBuy">💰 Mua thêm lượt</button>
    </div>

    <div class="chest-actions">
        <button class="chest-btn rewards" id="btnReward">🐞 Giải Thưởng</button>
        <button class="chest-btn history" id="btnHistory">🐉 Lịch Sử</button>
        <button class="chest-btn bag" id="btnBag">📭 Túi Đồ</button>
    </div>

    <script>
        const chest = document.getElementById("chest");
    const openBtn = document.getElementById("openBtn");
    const reward = document.getElementById("reward");

    $("#btnBuy").click(function() {
        document.getElementById('them-luot').classList.add('show');
    });

    $("#btnBag").click(function() {
        document.getElementById('tui-do').classList.add('show');
    });

    $("#btnReward").click(function() {
        document.getElementById('exchange-modal-giai-thuong').classList.add('show');
    });

    $("#btnHistory").click(function() {
        document.getElementById('exchange-modal-lich-su').classList.add('show');
    });

$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#openBtn").on("click", function() {
  let $btn = $(this);
  let originalText = $btn.text();

  // trạng thái loading
  $btn.prop("disabled", true).text("⏳ Đang mở rương...");
  $("#result").text(""); // clear trước

  $.ajax({
    url: "/ruong-may-man",
    method: "POST",
    dataType: "json",
    success: function(res) {
        if (res.status == "error") {
            $btn.prop("disabled", false).text(originalText);
            toastr.error(res.msg);
            return
        }
      // hiển thị phần thưởng
      $("#reward").html(`
        <div style="margin-top:10px; display:flex; align-items:center; justify-content:center; gap:10px;">
          <img src="${res.item.picture}" alt="${res.item.name}">
          <div style="font-weight:bold;color:#333;">x${res.item.quantity}</div>
        </div>
      `);

      // cập nhật số lần đã dùng
      if (res.type === "daily") {
        let numFree = parseInt($("#numFree").text(), 10) || 0;
        $("#numFree").text(numFree + 1);
      } else {
        let numPlus = parseInt($("#numPlus").text(), 10) || 0;
        $("#numPlus").text(numPlus + 1);
      }
    },
    error: function() {
      $("#result").text("⚠️ Lỗi kết nối, thử lại sau!");
    },
    complete: function() {
      // khôi phục nút
      $btn.prop("disabled", false).text(originalText);
    }
  });
});


    </script>
</div>


@endsection