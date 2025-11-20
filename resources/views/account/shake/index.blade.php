@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="/static/shake.css">
@include('shake.modal')
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-tree"></i> 🌳 Rung Cây Nhận Vật Phẩm
    </div>
    <div class="stats-grid">
        <div class="stat-card" onClick="document.getElementById('exchange-modal-the-le').classList.add('show');">

            <div class="stat-info">
                <div class="stat-label">Thể lệ</div>
            </div>
        </div>

        <div class="stat-card" onClick="document.getElementById('exchange-modal-giai-thuong').classList.add('show');">

            <div class="stat-info">
                <div class="stat-label">Giải Thưởng</div>
            </div>
        </div>

        <div class="stat-card" onClick="document.getElementById('exchange-modal-lich-su').classList.add('show');">

            <div class="stat-info">
                <div class="stat-label">LỊCH SỬ</div>
            </div>
        </div>
    </div>
    <div class="tree-container" onclick="shakeTree()">
        <div id="star-container"></div>
        <div class="sparkle"></div> <!-- ✨ hiệu ứng lấp lánh -->
        <img src="/static/bg-tree.png" alt="Cây" class="tree" id="tree">
        <div id="reward-area"></div>
    </div>

    <div class="message" id="message"></div>
    <div class="process-steps">
        <div class="process-step">
            <div class="step-title"><i class="fas fa-gift fs-4"></i> Miễn phí <span style="color:red">(<span
                        id="freeUsed">{{$wheel->usedTimes("free")}}</span>/3 lượt)</span></div>
        </div>
        <div class="process-step">
            <div class="step-title"><i class="fas fa-crown fs-4"></i> VIP thêm lượt <span style="color:red">(<span
                        id="vipUsed">{{$wheel->usedTimes("vip")}}</span>/{{Auth::user()->viplevel}} lượt)</span></div>
        </div>
        <div style="cursor: pointer" class="process-step"
            onClick="document.getElementById('them-luot').classList.add('show');">
            <div class="step-title"><i class="fas fa-feather fs-4"></i> Mua thêm <span style="color:red">(<span
                        id="plusUsed">{{$wheel->usedTimes("plus")}}</span>/{{$plus}}
                    lượt)</span></div>
        </div>
    </div>


</div>


<script>
    function createFallingStars(count = 10) {
        const container = document.getElementById('star-container');
        for (let i = 0; i < count; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.innerText = '🌟';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * -30 + 'px';
            star.style.fontSize = (12 + Math.random() * 10) + 'px';
            star.style.animationDuration = (2 + Math.random() * 2) + 's';

            container.appendChild(star);

            setTimeout(() => {
            container.removeChild(star);
            }, 4000);
        }
        }

        setInterval(() => {
        createFallingStars(3);
        }, 800);


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    async function shakeTree() {
     const shakeSound = new Audio('/static/shake.mp3');
     const failSound = new Audio('/static/fail.mp3');
      const tree = document.getElementById('tree');
      const treex = document.querySelector('.tree-container');
      treex.style.pointerEvents = 'none';
      const rewardArea = document.getElementById('reward-area');
      const message = document.getElementById('message');

      tree.classList.remove('shake');
      void tree.offsetWidth;
      tree.classList.add('shake');

      rewardArea.innerHTML = '';

      var reward;
      $.ajax({
            url: "/rung-cay",
            method: "POST",
            dataType: 'json',
            success: function(response) {
                if (response.status == 'error') {
                    toastr.error(response.msg);
                    treex.style.pointerEvents = 'auto';
                    failSound.currentTime = 0;
                    failSound.play();
                    return false;
                } else {
                    shakeSound.currentTime = 0;
                    shakeSound.play();
                    const reward = response.item
                    const rewardImg = document.createElement('img');
                    rewardImg.src = reward.picture;
                    rewardImg.className = 'reward';
                    rewardArea.appendChild(rewardImg);
                    const type = response.type

                    switch (type) {
                        case "free":
                            $("#freeUsed").text(response.used)
                            break;
                        case "vip":
                            $("#vipUsed").text(response.used)
                            break;
                        case "plus":
                            $("#plusUsed").text(response.used)
                            break;
                        default:
                            break;
                    }
                    setTimeout(() => {
                        message.innerHTML = `🎁 Bạn đã nhận được phần thưởng: <img src="${reward.picture}" alt="Reward"> ${reward.name} x${reward.quantity}`;
                    }, 500);

                    // Xóa phần thưởng rơi sau 2s
                    setTimeout(() => {
                        rewardImg.remove();
                    }, 2000);
                    treex.style.pointerEvents = 'auto';
                }
            }
        });
    }
</script>
@endsection