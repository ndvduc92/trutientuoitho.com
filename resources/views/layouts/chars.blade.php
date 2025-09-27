<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Character Select</title>
<style>
  body {
    background: radial-gradient(circle at top, #0a1744, #051027);
    font-family: 'Segoe UI', sans-serif;
    color: #fff;
  }

  .character-box {
    width: 1000px;
    margin: 40px auto;
    padding: 20px;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 12px;
    background: rgba(0,0,0,0.4);
    box-shadow: 0 0 20px rgba(255,255,255,0.05);
    position: relative;
  }

  .character-box h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #ff3c3c;
    font-size: 22px;
    text-shadow: 0 0 8px rgba(255,60,60,0.6);
  }

  .character-list {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: flex-start;
  }

  .character-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(to right, rgba(20,20,40,0.8), rgba(15,15,30,0.8));
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    padding: 12px 18px;
    flex: 1 1 300px;
    transition: 0.2s ease;
    cursor: pointer;
    position: relative;
  }

  .character-card:hover,
  .character-card.active {
    border: 1px solid gold;
    box-shadow: 0 0 12px rgba(255,215,0,0.7);
    background: linear-gradient(to right, rgba(60,40,10,0.9), rgba(40,30,10,0.9));
  }

  .char-info {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .char-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #999;
  }
  .char-avatar img {
    width: 100%; height: 100%; object-fit: cover;
  }

  .char-details {
    display: flex;
    flex-direction: column;
  }
  .char-name {
    font-weight: bold;
    font-size: 18px;
  }
  .char-class {
    font-size: 14px;
    color: #9ecae1;
  }

  .char-level {
    background: rgba(0,0,0,0.4);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 18px;
    padding: 6px 14px;
    font-size: 14px;
    font-weight: bold;
  }

  .toggle-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 6px;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
    padding: 4px 6px;
  }
</style>
</head>
<body>

<div class="character-box">
  <h2>Change your character</h2>
  <button class="toggle-btn">⌃</button>

  <div class="character-list">
    <div class="character-card active">
      <div class="char-info">
        <div class="char-avatar"><img src="https://via.placeholder.com/40" alt=""></div>
        <div class="char-details">
          <span class="char-name">Slzys</span>
          <span class="char-class">Balo</span>
        </div>
      </div>
      <div class="char-level">Lvl 1</div>
    </div>

    <div class="character-card">
      <div class="char-info">
        <div class="char-avatar"><img src="https://via.placeholder.com/40" alt=""></div>
        <div class="char-details">
          <span class="char-name">Stillz</span>
          <span class="char-class">Balo</span>
        </div>
      </div>
      <div class="char-level">Lvl 1</div>
    </div>

    <div class="character-card">
      <div class="char-info">
        <div class="char-avatar"><img src="https://via.placeholder.com/40" alt=""></div>
        <div class="char-details">
          <span class="char-name">Sluz</span>
          <span class="char-class">Balo</span>
        </div>
      </div>
      <div class="char-level">Lvl 1</div>
    </div>

    <div class="character-card">
      <div class="char-info">
        <div class="char-avatar"><img src="https://via.placeholder.com/40" alt=""></div>
        <div class="char-details">
          <span class="char-name">NewStar</span>
          <span class="char-class">Initiate</span>
        </div>
      </div>
      <div class="char-level">Lvl 1</div>
    </div>
  </div>
</div>

</body>
</html>
