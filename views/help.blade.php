@extends('layouts.master')
@section('content')
<style>
  /* Filter and view toggles */
  .stash-filters {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .filter-tabs {
    display: flex;
    background-color: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    overflow: hidden;
  }

  .stone {
    color: #2ecc71;
  }

  .filter-tab {
    padding: 8px 15px;
    color: var(--text-color);
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .filter-tab:hover {
    background-color: rgba(212, 175, 55, 0.1);
    color: var(--accent-color);
  }

  .filter-tab.active {
    background-color: rgba(212, 175, 55, 0.2);
    color: var(--accent-color);
  }

  .view-toggle {
    display: flex;
    background-color: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    overflow: hidden;
  }

  .view-toggle a {
    padding: 8px 15px;
    color: var(--text-color);
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
  }

  .view-toggle a i {
    margin-right: 5px;
  }



  .view-toggle a:hover {
    background-color: rgba(212, 175, 55, 0.1);
    color: var(--accent-color);
  }

  .view-toggle a.active {
    background-color: rgba(212, 175, 55, 0.2);
    color: var(--accent-color);
  }

  /* Stash items grid */
  .stash-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
  }

  .stash-items {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 5px 15px var(--shadow-color);
  }

  .stash-items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
  }

  .stash-items-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .stash-item {
    background-color: rgba(0, 0, 0, 0.3);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .stash-item:hover {
    border-color: var(--accent-color);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3), 0 0 5px var(--accent-glow);
  }

  .stash-item.active {
    border-color: var(--accent-color);
    box-shadow: 0 0 10px var(--accent-glow);
    background-color: rgba(212, 175, 55, 0.1);
  }

  /* Compact item style */
  .stash-item.compact {
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 120px;
  }

  .item-icon {
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 10px;
  }

  .item-icon img {
    max-width: 100%;
    max-height: 100%;
  }

  .item-name {
    font-size: 0.85rem;
    color: var(--text-color);
    text-align: center;
    margin-bottom: 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.3;
  }

  .item-source {
    font-size: 0.7rem;
    padding: 2px 6px;
    background-color: rgba(212, 175, 55, 0.1);
    border-radius: 3px;
    color: var(--accent-color);
  }

  .stack-quantity {
    position: absolute;
    bottom: 5px;
    right: 5px;
    font-size: 0.7rem;
    background-color: rgba(0, 0, 0, 0.5);
    padding: 2px 4px;
    border-radius: 3px;
    color: var(--accent-color);
    font-weight: bold;
  }

  /* Detailed item style */
  .stash-item.detailed {
    padding: 12px;
    display: flex;
    align-items: center;
  }

  .stash-item.detailed .item-icon {
    margin-bottom: 0;
    margin-right: 12px;
  }

  .stash-item.detailed .item-info {
    flex: 1;
  }

  .stash-item.detailed .item-name {
    text-align: left;
    font-size: 0.9rem;
    margin-bottom: 3px;
  }

  .stash-item.detailed .item-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    color: var(--text-muted);
  }

  .stash-item.detailed .item-source {
    margin-left: auto;
  }

  /* Item preview panel */
  .item-preview {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 5px 15px var(--shadow-color);
    position: sticky;
    top: 20px;
  }

  .preview-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    color: var(--text-muted);
    text-align: center;
  }

  .preview-empty i {
    font-size: 3rem;
    margin-bottom: 15px;
    color: var(--border-color);
  }

  .preview-empty p {
    font-size: 1rem;
    margin: 0;
  }

  .item-details {
    display: none;
  }

  .item-details h3 {
    font-size: 1.3rem;
    margin-top: 0;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
  }

  .item-image {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }

  .item-image img {
    max-width: 80px;
    max-height: 80px;
    filter: drop-shadow(0 0 5px var(--accent-glow));
  }

  .item-meta {
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .item-meta .source {
    font-size: 0.85rem;
    padding: 3px 8px;
    background-color: rgba(212, 175, 55, 0.1);
    border-radius: 4px;
    color: var(--accent-color);
  }

  .item-meta .date {
    font-size: 0.85rem;
    color: var(--text-muted);
  }

  .item-description {
    background-color: rgba(0, 0, 0, 0.2);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
    font-size: 0.9rem;
    color: var(--text-color);
    line-height: 1.6;
  }

  .quantity-display {
    background-color: rgba(0, 0, 0, 0.2);
    border: 1px solid var(--border-color);
    border-radius: 5px;
    padding: 10px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .quantity-display .label {
    font-size: 0.9rem;
    color: var(--text-muted);
  }

  .quantity-display .value {
    font-size: 1rem;
    font-weight: bold;
    color: var(--accent-color);
  }

  .split-quantity {
    display: none;
    margin-bottom: 20px;
  }

  .split-quantity label {
    display: block;
    margin-bottom: 10px;
    font-size: 0.9rem;
    color: var(--text-color);
  }

  .split-controls {
    display: flex;
    align-items: center;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    overflow: hidden;
    width: fit-content;
  }

  .split-controls button {
    width: 30px;
    height: 30px;
    background-color: rgba(0, 0, 0, 0.3);
    border: none;
    color: var(--text-color);
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .split-controls button:hover {
    background-color: rgba(212, 175, 55, 0.2);
    color: var(--accent-color);
  }

  .split-controls input {
    width: 50px;
    text-align: center;
    border: none;
    background-color: rgba(0, 0, 0, 0.2);
    color: var(--text-color);
    font-weight: bold;
    padding: 5px;
  }

  .item-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .item-action-btn {
    padding: 10px 0;
    background: var(--button-gradient);
    color: var(--primary-bg);
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .item-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  }

  .item-action-btn i {
    margin-right: 8px;
  }

  .item-action-btn.secondary {
    background: rgba(0, 0, 0, 0.3);
    color: var(--text-color);
    border: 1px solid var(--border-color);
  }

  .item-action-btn.secondary:hover {
    background: rgba(0, 0, 0, 0.5);
    color: var(--accent-color);
  }

  /* Alert messages */
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

  /* Claimed history section */
  .history-section {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    margin-top: 20px;
    overflow: hidden;
    box-shadow: 0 5px 15px var(--shadow-color);
  }

  .history-header {
    background-color: rgba(0, 0, 0, 0.3);
    padding: 15px 20px;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
  }

  .history-header h3 {
    margin: 0;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
  }

  .history-header h3 i {
    margin-right: 10px;
  }

  .history-header .toggle-icon {
    transition: transform 0.3s ease;
  }

  .history-content {
    display: none;
    max-height: 300px;
    overflow-y: auto;
    padding: 15px;
  }

  .history-content.active {
    display: block;
  }

  .history-empty {
    text-align: center;
    padding: 20px;
    color: var(--text-muted);
  }

  .history-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid var(--border-color);
  }

  .history-item:last-child {
    border-bottom: none;
  }

  .history-item-icon {
    width: 40px;
    height: 40px;
    margin-right: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .history-item-icon img {
    max-width: 100%;
    max-height: 100%;
  }

  .history-item-info {
    flex: 1;
  }

  .history-item-name {
    font-size: 0.9rem;
    color: var(--text-color);
    margin-bottom: 5px;
  }

  .history-item-details {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    justify-content: space-between;
  }

  /* Responsive styles */
  @media (max-width: 1200px) {
    .stash-dashboard {
      width: 95%;
    }
  }

  @media (max-width: 992px) {
    .stash-dashboard {
      grid-template-columns: 1fr;
    }

    .sidebar {
      margin-bottom: 20px;
    }

    .character-selector {
      flex-direction: column;
      gap: 15px;
      align-items: flex-start;
    }

    .stash-container {
      grid-template-columns: 1fr;
    }

    .item-preview {
      position: static;
      margin-top: 20px;
    }
  }

  @media (max-width: 768px) {
    .stash-items-grid {
      grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    }

    .stash-filters {
      flex-direction: column;
      gap: 10px;
    }

    .filter-tabs,
    .view-toggle {
      width: 100%;
      justify-content: center;
    }
  }

  @media (max-width: 576px) {
    .stash-items-grid {
      grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    }

    .stash-item.compact {
      height: 100px;
    }

    .character-selector,
    .stash-stats {
      flex-direction: column;
      align-items: stretch;
    }
  }

  /* Animations */
  @keyframes pulse {
    0% {
      box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
    }

    70% {
      box-shadow: 0 0 0 6px rgba(46, 204, 113, 0);
    }

    100% {
      box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
    }
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  @keyframes float {
    0% {
      transform: translateY(0px);
    }

    50% {
      transform: translateY(-5px);
    }

    100% {
      transform: translateY(0px);
    }
  }

  .chars-list {
    display: none
  }

  #tranlinh img {
    width: 100%;
  }
</style>
@php
$source = request('type', 'tl');
$types = ['tl' => "Trận Linh", 'na' => "Nguyên Anh", 'bc' => "Bội chương", 'sach' => "Hiên Viên sách"];
@endphp
<div class="main-content">
  <div class="stash-filters">
    <div class="filter-tabs">
      <a href="?type=tl" class="filter-tab {{ $source == 'tl' ? 'active' : ''}}">
        Trận linh </a>
      <a href="?type=na" class="filter-tab {{ $source == 'na' ? 'active' : ''}}">
        Nguyên Anh </a>
      <a href="?type=bc" class="filter-tab {{ $source == 'bc' ? 'active' : ''}}">
        Bội chương </a>
        <a href="?type=sach" class="filter-tab {{ $source == 'sach' ? 'active' : ''}}">
        Hiên Viên sách </a>
    </div>
  </div>
  <!-- Claimed Items History -->
  <div class="account-section" style="">
    <div class="account-section-title">
      <a href="?refresh=yes"><i class="fa-brands fa-guilded"></i></a> Hướng Dẫn {{$types[$source] ?? 'Trận Linh' }}
    </div>
    <style>
      .tran {
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        color: #FFD700;
        padding: 12px 20px;
        border: 2px solid #FFD700;
        border-radius: 12px;
        background: linear-gradient(145deg, #1c1f2b, #2a2f3e);
        box-shadow: 0 0 10px #FFD700, 0 0 20px #FFA500 inset;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: relative;
        display: inline-block;
      }
    </style>
    @if ($source == 'tl')
    <section id="tranlinh">
      <h3>Trận Tham Khảo</h3>
      <p class="tran">Trận full trúng</p>
      <img class="huongdan" src="/static/trung.png" alt="">
      <br>
      <p class="tran">Trận full né</p>
      <img class="huongdan" src="/static/ne.png" alt="">

      <br>
      <p class="tran">Trận full giảm bạo kích</p>
      <img class="huongdan" src="/static/gbk.png" alt="">
    </section>
    @elseif ($source == 'na')
    <section id="tranlinh">
      <h3>Nguyên Anh</h3>
    </section>
    @elseif ($source == 'bc')
    <section id="tranlinh">
      <h3>Bội chương</h3>
    </section>
    @else
    <section id="tranlinh">
      <h3>Bội chương</h3>
    </section>
    @endif
  </div>
</div>
@endsection