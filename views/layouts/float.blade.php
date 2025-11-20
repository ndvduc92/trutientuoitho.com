<div id="toggleMenuBtn">☰</div>

<!-- Float Menu -->
<div id="floatMenu" class="float-menu">
    <a href="https://trutienvietnam.com" target="_blank">🏠 Trang chủ</a>
    <a href="https://facebook.com/trutienvietnam2025" target="_blank"><i class="fab fa-facebook"></i> Fanpage</a>
    <a href="https://trutienvietnam.com?download=true" target="_blank">⬇️ Tải game</a>
</div>

<style>
/* Toggle button */
#toggleMenuBtn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #00a1d6; /* xanh chủ đạo */
  color: #fff;
  padding: 12px 14px;
  border-radius: 50%;
  cursor: pointer;
  z-index: 10001;
  font-size: 18px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  transition: background 0.3s;
}

#toggleMenuBtn:hover {
  background: #008bb5;
}

/* Float Menu */
.float-menu {
  position: fixed;
  bottom: 70px; /* nằm trên nút */
  right: 20px;
  width: 180px;
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.1);
  overflow: hidden;
  z-index: 10000;
  transform: translateY(20px);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.float-menu.show {
  transform: translateY(0);
  opacity: 1;
  visibility: visible;
}

.float-menu a {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 16px;
  color: #333;
  text-decoration: none;
  font-size: 15px;
  border-bottom: 1px solid #f0f0f0;
  transition: background 0.2s, color 0.2s;
}

.float-menu a:last-child {
  border-bottom: none;
}

.float-menu a:hover {
  background: #f7f7f7;
  color: #00a1d6;
}
</style>

<script>
const toggleBtn = document.getElementById('toggleMenuBtn');
const floatMenu = document.getElementById('floatMenu');

toggleBtn.addEventListener('click', () => {
  floatMenu.classList.toggle('show');
});
</script>
