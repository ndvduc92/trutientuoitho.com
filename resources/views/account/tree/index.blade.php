<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Rung Cây Nhận Vật Phẩm</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      text-align: center;
    }

    .tree-container {
      position: relative;
      width: 800px;
      margin: auto;
    }

    .highlight {
      animation: highlightBlink 1s ease-in-out infinite;
      box-shadow: 0 0 25px gold, 0 0 15px orange inset;
      border-radius: 10px;
    }


    @keyframes highlightBlink {
      0% {
        transform: scale(1);
        filter: brightness(1);
      }

      50% {
        transform: scale(1.3);
        filter: brightness(1.8);
      }

      100% {
        transform: scale(1);
        filter: brightness(1);
      }
    }

    .tree-img {
      width: 100%;
      user-select: none;
    }

    .item {
      position: absolute;
      width: 52px;
      height: 52px;
      border-radius: 6px;
      background: rgba(0, 0, 0, 0.35);
      padding: 4px;
      backdrop-filter: blur(3px);
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.4);
      transition: transform 0.2s ease;
    }

    .item:hover {
      transform: scale(1.12);
      z-index: 10;
    }


    .buttons {
      margin-top: 20px;
    }

    button {
      padding: 10px 16px;
      margin: 5px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }

    .free {
      background: #7fcf8a;
    }

    .buy {
      background: #e8c045;
    }

    .basket {
      background: #5ca3d1;
      color: white;
    }
  </style>
</head>

<body>
  <nav class="navbar bg-dark navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/account">Đại Sảnh</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        </ul>
        <form class="d-flex" role="search">
          <button class="btn btn-outline-success" type="submit">{{Auth::user()->name}}</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="tree-container mt-2">
    <img src="/assets/tree.png" class="tree-img" />
    <div id="items"></div>
  </div>
  <button class="btn btn-success mt-4" id="openBtn">Rung cây</button>
  <div class="buttons">
    <button class="btn btn-secondary">Miễn phí mỗi ngày(<span
        id="numFree">{{$wheel->usedTimes("free")}}</span>/2)</button>
    <button class="btn btn-warning">Số lượt mua thêm <span
        id="numPlus">{{$wheel->usedTimes("plus")}}</span>/{{$plus}}</button>
    <button class="btn btn-danger" id="btnBuy">Mua lượt rung</button>
    <button class="btn btn-primary" id="btnBag">Túi đồ</button>
  </div>

  @if (session('error'))
  <script>
    alert("{{ session('error') }}");
  </script>
  @endif


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  @include('account.tree.modal')
  <script>
    $("#btnBuy").click(function() {
        document.getElementById('them-luot').classList.add('show');
    });

    $("#btnBag").click(function() {
        document.getElementById('tui-do').classList.add('show');
    });

    const itemContainer = document.getElementById('items');
    itemContainer.innerHTML = "";

   const positions = [
  // Tầng 1 – Trên
  { top: 40, left: 150 },
  { top: 35, left: 230 },
  { top: 38, left: 310 },
  { top: 42, left: 390 },
  { top: 36, left: 470 },
  { top: 40, left: 550 },

  // Tầng 2 – Giữa
  { top: 110, left: 120 },
  { top: 115, left: 190 },
  { top: 108, left: 260 },
  { top: 120, left: 330 },
  { top: 112, left: 400 },
  { top: 118, left: 470 },
  { top: 123, left: 540 },
  { top: 128, left: 610 },

  // Tầng 3 – Dưới
  { top: 180, left: 170 },
  { top: 188, left: 250 },
  { top: 192, left: 330 },
  { top: 198, left: 410 },
  { top: 205, left: 490 },
  { top: 212, left: 570 }
];

    const items = @json($items ?? []);

   positions.forEach((pos, index) => {
      const item = document.createElement('img');
      item.src = items[index].picture
      item.dataset.id = items[index].itemid;
      item.className = 'item';
      item.title = items[index].name + ' (x' + items[index]['quantity'] + ')';
      item.style.top = pos.top + 'px';
      item.style.left = (pos.left + 20) + 'px';
      itemContainer.appendChild(item);
    })

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
        url: "/account/rung-cay",
        method: "POST",
        dataType: "json",
        success: function(res) {
            if (res.status == "error") {
                $btn.prop("disabled", false).text(originalText);
                alert(res.msg);
                return
            }
          // hiển thị phần thưởng
          if (res.type === "free") {
        let numFree = parseInt($("#numFree").text(), 10) || 0;
        $("#numFree").text(numFree + 1);
      } else {
        let numPlus = parseInt($("#numPlus").text(), 10) || 0;
        $("#numPlus").text(numPlus + 1);
      }
          const rewardId = res.item.itemid;

    const foundItem = document.querySelector(`img[data-id="${rewardId}"]`);

    if (foundItem) {
        // xóa highlight cũ (nếu có)
        document.querySelectorAll('.highlight').forEach(el => el.classList.remove('highlight'));

        // thêm highlight
        foundItem.classList.add('highlight');
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
</body>

</html>