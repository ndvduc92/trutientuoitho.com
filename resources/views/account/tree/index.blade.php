<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rung Cây Nhận Vật Phẩm</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      text-align: center;
      padding: 20px;
    }

    .tree-container {
      position: relative;
      width: 800px;
      margin: auto;
    }

    .tree-img {
      width: 100%;
      user-select: none;
    }

    /* Item nhấp nháy */
    .item {
      position: absolute;
      width: 48px;
      height: 48px;
      animation: blink 1.2s infinite ease-in-out;
    }

    @keyframes blink {
      0%   { opacity: 1; transform: scale(1); }
      50%  { opacity: 0.4; transform: scale(1.1); }
      100% { opacity: 1; transform: scale(1); }
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
    .free { background: #7fcf8a; }
    .buy { background: #e8c045; }
    .basket { background: #5ca3d1; color: white; }
  </style>
</head>
<body>
  <h2>Rung Cây Nhận Vật Phẩm</h2>

  <div class="tree-container">
    <img src="/assets/tree.png" class="tree-img" />
    <div id="items"></div>
  </div>

  <div class="buttons">
    <button class="free">Miễn phí (1/1)</button>
    <button class="buy">Mua thêm lượt</button>
    <button class="basket">Giỏ trái cây</button>
  </div>

  <script>
    const itemContainer = document.getElementById('items');
    itemContainer.innerHTML = "";

    const positions = [
      { top: 40, left: 80 },
      { top: 30, left: 150 },
      { top: 50, left: 220 },
      { top: 20, left: 300 },
      { top: 60, left: 360 },
      { top: 35, left: 430 },
      { top: 70, left: 500 },
      { top: 90, left: 140 },
      { top: 110, left: 240 },
      { top: 115, left: 330 },
      { top: 120, left: 420 },
      { top: 139, left: 520 }
    ];

    const items = @json($daily['items'] ?? []);

   positions.forEach((pos, index) => {
      const item = document.createElement('img');
      item.src = items[index].picture
      item.className = 'item';
      item.style.top = pos.top + 'px';
      item.style.left = (pos.left + 20) + 'px';
      itemContainer.appendChild(item);
    })
  </script>
</body>
</html>
