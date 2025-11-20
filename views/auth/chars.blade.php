<div class="account-section">
  <div class="account-section-title">
    <i class="fas fa-users"></i> Danh sách nhân vật
  </div>

  @if(count(Auth::user()->chars()))
  <div class="character-box">
    <div class="character-list">
      @foreach (Auth::user()->chars() as $char)
      <div class="character-card {{Auth::user()->main_id == $char->char_id ? 'active' : ''}}"
        data-id="{{$char->char_id}}">
        <div class="char-info">
          <div class="char-avatar">{!! $char->class_icon !!}</div>
          <div class="char-details">
            <span class="char-name">{{$char->name}}</span>
            <span class="char-class">{{$char->className}}</span>
          </div>
          <div class="status {{isYouOnline() ? 'online' : 'offline'}}"></div>
        </div>
        <div class="char-level">{{$char->char_id}}</div>
      </div>
      @endforeach

    </div>
    <p>Chưa có nhân vật nào, nhấn <a href="/chars">VÀO ĐÂY</a> để cập nhật nếu chưa có</p>
    <style>
      .character-list {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* mặc định 3 card mỗi hàng */
        gap: 15px;
      }

      /* Card nhân vật */
      .character-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 20px #1baac2;
        border: 1px solid #1baac2;
        border-radius: 12px;
        padding: 14px 20px;
        color: #000;
        cursor: pointer;
        transition: all 0.25s ease;
      }

      .character-card:hover {
        border: 1px solid #1baac2;
        box-shadow: 0 0 10px #1baac2;
        transform: translateY(-3px);
      }

      .character-card.active {
        border: 1px solid #1baac2;
        background: #1baac2;
        color: #fff;
        box-shadow: 0 0 12px #1baac2;
      }

      /* Thông tin trong card */
      .char-info {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .char-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #222;
        border: 2px solid #666;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .char-details {
        display: flex;
        flex-direction: column;
      }

      .char-name {
        font-size: 16px;
        font-weight: 600;
      }

      .char-class {
        font-size: 13px;
        opacity: 0.8;
      }

      /* Level badge */
      .char-level {
        font-size: 14px;
        font-weight: bold;
        padding: 6px 14px;
        border-radius: 20px;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
      }

      /* Responsive */
      @media (max-width: 992px) {
        .character-list {
          grid-template-columns: repeat(2, 1fr);
          /* tablet: 2 card / hàng */
        }
      }

      @media (max-width: 576px) {
        .character-list {
          grid-template-columns: 1fr;
          /* mobile: 1 card / hàng */
        }
      }
    </style>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
  // lấy toàn bộ thẻ nhân vật
  const cards = document.querySelectorAll(".character-card");

  cards.forEach(card => {
    card.addEventListener("click", function() {
      // giả sử mỗi card có data-id
      const charId = this.getAttribute("data-id");
      const charName = this.querySelector(".char-name").textContent;

      if (charName === "Không thấy nhân vật?") {
        window.location.href = "/chars";
      } else if (charId) {
        window.location.href = `/set_main_char/${charId}`;
      }
    });
  });
});
  </script>
  @else
  <span>Chưa có nhân vật nào, nhấn <a href="/chars">VÀO ĐÂY</a> để cập nhật nếu chưa có</span>
  @endif


</div>