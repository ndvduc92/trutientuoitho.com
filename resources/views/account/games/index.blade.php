@extends('layouts.master')
@section('content')
<style>
    /* Custom styles combining both designs */
    /* Main grid layout */
    .rewards-dashboard {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
        width: 95%;
        max-width: 1400px;
        margin: 30px auto;
    }

    /* Sidebar */
    .sidebar {
        background: var(--card-gradient);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px var(--shadow-color);
    }



    .user-profile::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 10%;
        right: 10%;
        height: 1px;
        background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        opacity: 0.5;
    }

    .avatar-container {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 15px;
    }

    .avatar-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--accent-color);
        box-shadow: 0 0 15px var(--accent-glow);
    }


    .server-status-panel {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        background: rgba(0, 0, 0, 0.3);
        border-top: 1px solid var(--border-color);
    }

    .status-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .status-indicator.online {
        background-color: #2ecc71;
        box-shadow: 0 0 10px rgba(46, 204, 113, 0.7);
        animation: pulse 2s infinite;
    }

    .status-indicator.offline {
        background-color: #e74c3c;
    }

    .status-text {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* Main content */
    .main-content {
        display: flex;
        flex-direction: column;
    }

    .section-title {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .section-title h3 {
        margin: 0;
        font-size: 2rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .section-title .gift-icon {
        font-size: 2rem;
        margin-right: 15px;
        color: var(--accent-color);
        animation: float 3s ease-in-out infinite;
    }

    .decorative-line {
        flex: 1;
        height: 2px;
        background: #1baac2;
        margin-left: 20px;
        opacity: 0.5;
        min-width: 50px;
    }

    /* Alert messages */
    .alert {
        padding: 15px 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid;
        position: relative;
        overflow: hidden;
        animation: slideInDown 0.3s ease-out;
    }

    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background-color: currentColor;
    }

    .alert-success {
        background-color: rgba(46, 204, 113, 0.1);
        border-color: rgba(46, 204, 113, 0.3);
        color: #2ecc71;
    }

    .alert-danger {
        background-color: rgba(231, 76, 60, 0.1);
        border-color: rgba(231, 76, 60, 0.3);
        color: #e74c3c;
    }

    .alert i {
        margin-right: 10px;
    }

    /* Stats summary */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--card-gradient);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        border-color: var(--accent-color);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, var(--accent-glow) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .stat-card:hover::before {
        opacity: 0.1;
    }

    .stat-icon {
        font-size: 2.5rem;
        color: var(--accent-color);
        margin-bottom: 10px;
        filter: drop-shadow(0 0 5px var(--accent-glow));
    }

    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        color: var(--text-highlight);
        margin-bottom: 5px;

        text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }


    .btn {
        padding: 12px 25px;
        font-size: 0.95rem;
        font-weight: 500;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;

    }

    .btn-primary {
        background: linear-gradient(to bottom, var(--accent-color), var(--accent-dark));
        color: var(--primary-bg);
        border: 1px solid var(--accent-color);
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    }

    .btn-primary:hover {
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
        transform: translateY(-2px);
    }

    /* Category tabs */
    .category-tabs-section {
        margin-bottom: 30px;
    }

    .category-tabs {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        padding: 10px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
        border: 1px solid var(--border-color);
    }

    .category-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: transparent;
        color: var(--text-color);
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;

        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .category-tab i {
        font-size: 1.1rem;
        color: var(--accent-color);
    }

    .category-tab:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
        border-color: var(--accent-color);
        transform: translateY(-2px);
    }

    .category-tab.active {
        background: rgba(212, 175, 55, 0.2);
        color: var(--accent-color);
        border-color: var(--accent-color);
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    }

    /* Category sections */
    .category-section {
        margin-bottom: 40px;
    }

    .category-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(to right, rgba(212, 175, 55, 0.1), transparent);
        padding: 15px 20px;
        border-left: 4px solid var(--accent-color);
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .category-title {
        display: flex;
        align-items: center;
        font-size: 1.5rem;
        color: var(--accent-color);

        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 0;
    }

    .category-title i {
        margin-right: 15px;
        font-size: 1.8rem;
    }

    .category-count {
        background: rgba(212, 175, 55, 0.2);
        color: var(--accent-color);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: bold;
    }

    /* Rewards grid - Updated from rewards_output2 */
    .rewards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    /* Reward card - Enhanced from rewards_output2 */
    .reward-card {
        background: var(--card-gradient);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .reward-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        border-color: var(--accent-color);
    }

    .reward-card.claimed {
        opacity: 0.6;
    }

    .reward-card.claimed::after {
        content: 'CLAIMED';
        position: absolute;
        top: 10px;
        right: -30px;
        background: rgba(46, 204, 113, 0.9);
        color: white;
        padding: 5px 40px;
        transform: rotate(45deg);
        font-size: 0.8rem;
        font-weight: bold;
        letter-spacing: 1px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .reward-card.on-cooldown::after {
        content: 'COOLDOWN';
        position: absolute;
        top: 10px;
        right: -30px;
        background: rgba(243, 156, 18, 0.9);
        color: white;
        padding: 5px 40px;
        transform: rotate(45deg);
        font-size: 0.8rem;
        font-weight: bold;
        letter-spacing: 1px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .reward-header {
        padding: 20px;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), transparent);
        border-bottom: 1px solid rgba(212, 175, 55, 0.1);
    }

    .reward-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px;
        background: rgba(212, 175, 55, 0.1);
        border: 2px solid var(--accent-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .reward-icon img {
        width: 80%;
        height: 80%;
        object-fit: contain;
        filter: drop-shadow(0 0 5px var(--accent-glow));
    }

    .reward-icon i {
        font-size: 2rem;
        color: var(--accent-color);
        filter: drop-shadow(0 0 5px var(--accent-glow));
    }

    .reward-name {
        text-align: center;
        font-size: 1.2rem;
        color: var(--accent-color);
        margin: 0;

        text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .reward-body {
        padding: 20px;
    }

    .reward-description {
        color: var(--text-color);
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 15px;
        min-height: 50px;
    }

    .reward-requirement {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .reward-requirement i {
        margin-right: 8px;
        color: var(--accent-color);
    }

    .reward-requirement.requirement-met {
        background: rgba(46, 204, 113, 0.1);
        border: 1px solid rgba(46, 204, 113, 0.3);
        color: #2ecc71;
    }

    .reward-requirement.requirement-not-met {
        background: rgba(231, 76, 60, 0.1);
        border: 1px solid rgba(231, 76, 60, 0.3);
        color: #e74c3c;
    }

    /* Enhanced reward items display */
    .reward-items {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 15px;
    }

    .reward-items-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Item list - maintaining organized list from rewards_output */
    .reward-item {
        display: flex;
        align-items: center;
        padding: 5px 0;
    }

    .reward-item-icon {
        width: 30px;
        height: 30px;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .reward-item-icon img {
        max-width: 100%;
        max-height: 100%;
    }

    .reward-item-name {
        flex: 1;
        font-size: 0.9rem;
        color: var(--text-color);
    }

    .reward-item-quantity {
        font-size: 0.8rem;
        color: var(--accent-color);
        font-weight: bold;
    }

    .reward-actions {
        display: flex;
        gap: 10px;
    }

    .btn-claim {
        flex: 1;
        background: linear-gradient(to bottom, var(--accent-color), var(--accent-dark));
        color: var(--primary-bg);
        border: 1px solid var(--accent-color);
        padding: 5px 10px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;

        font-weight: 500;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-claim.won {
        color: #fff;
        background: #28a745;
        border-color: #28a745;
    }

    .btn-claim.lost {
        color: #fff;
        background: #dc3545;
        border-color: #dc3545;
    }

    .btn-claim:hover:not(:disabled) {
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
        transform: translateY(-2px);
    }

    .btn-claim:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: gray;
        border-color: gray;
    }

    .cooldown-timer {
        text-align: center;
        color: #f39c12;
        font-size: 0.9rem;
        margin-top: 10px;
        font-weight: bold;
    }

    /* Character selector */
    .character-selector {
        margin-bottom: 15px;
    }

    .character-selector select {
        width: 100%;
        padding: 8px 12px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        color: var(--text-color);
        font-size: 0.9rem;
    }

    .character-selector select:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 5px var(--accent-glow);
    }

    /* Footer */
    .footer {
        margin-top: auto;
        background: var(--header-gradient);
        padding: 20px 0;
        color: var(--text-muted);
        text-align: center;
        border-top: 1px solid var(--border-color);
    }

    .footer p {
        margin: 5px 0;
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

    @keyframes slideInDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    @keyframes vipGlow {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    /* Loading animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(212, 175, 55, 0.3);
        border-radius: 50%;
        border-top-color: var(--accent-color);
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .rewards-dashboard {
            width: 95%;
        }

        .stats-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .mobile-menu-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rewards-dashboard {
            grid-template-columns: 1fr;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 280px;
            height: 100%;
            z-index: 200;
            transition: left 0.3s ease;
        }

        .sidebar.mobile-active {
            left: 0;
        }

        .mobile-close-btn {
            display: flex;
        }

        .section-title {
            justify-content: center;
            text-align: center;
        }

        .decorative-line {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .header-container {
            flex-direction: column;
            gap: 15px;
        }

        .logo img {
            height: 50px;
        }

        .main-nav {
            display: none;
        }

        .server-status {
            order: -1;
            margin-bottom: 10px;
        }

        .welcome-banner {
            font-size: 1rem;
            padding: 10px;
        }

        .rewards-dashboard {
            margin: 15px auto;
            gap: 20px;
        }

        .section-title h3 {
            font-size: 1.5rem;
        }

        .section-title .gift-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .stats-summary {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-icon {
            font-size: 2rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .stat-label {
            font-size: 0.8rem;
        }

        .rewards-grid {
            grid-template-columns: 1fr;
        }

        .promo-code-form {
            flex-direction: column;
        }

        .promo-code-input {
            width: 100%;
        }

        .btn {
            width: 100%;
        }

        .category-tabs {
            justify-content: flex-start;
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--accent-color) rgba(0, 0, 0, 0.3);
        }

        .category-tabs::-webkit-scrollbar {
            height: 6px;
        }

        .category-tabs::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
        }

        .category-tabs::-webkit-scrollbar-thumb {
            background-color: var(--accent-color);
            border-radius: 3px;
        }

        .category-tab {
            padding: 8px 15px;
            font-size: 0.85rem;
        }

        .category-header {
            padding: 10px 15px;
            flex-direction: column;
            align-items: flex-start;
        }

        .category-title {
            font-size: 1.2rem;
        }

        .vip-badge {
            padding: 10px 20px;
            font-size: 0.9rem;
            gap: 10px;
        }

        .reward-card {
            max-width: 100%;
        }
    }

    @media (max-width: 480px) {
        .sidebar {
            width: 85%;
        }

        .stats-summary {
            grid-template-columns: 1fr;
        }

        .promo-code-title {
            font-size: 1.1rem;
        }

        .promo-code-input {
            font-size: 0.9rem;
            padding: 10px 15px;
        }

        .btn {
            font-size: 0.85rem;
            padding: 10px 20px;
        }

        .reward-header {
            padding: 15px;
        }

        .reward-name {
            font-size: 1.1rem;
        }

        .reward-body {
            padding: 15px;
        }

        .reward-description {
            font-size: 0.85rem;
        }

        .reward-requirement {
            font-size: 0.85rem;
            padding: 8px;
        }

        .btn-claim {
            font-size: 0.85rem;
            padding: 8px 15px;
        }
    }
</style>
@php
$category = request()->get('category', 'lottery');
@endphp
{{-- <div class="category-tabs-section">
    <div class="category-tabs">
        <a href="?category=lottery" class="category-tab {{ $category == 'lottery' ? 'active' : '' }}">
            <i class="fas fa-gift"></i>
            <span>Xổ số miền Bắc</span>
        </a>
    </div>
</div> --}}
<div class="dashboard-section">
    <h3><i class="fas fa-chart-bar"></i> Dự đoán kết quả Xổ Số Miền Bắc hôm nay</h3>
    <div class="security-tips">
        <form id="contact-form" action="" method="post">
            @csrf
            <div class="category-tabs">
                <span name="de" class="category-tab active">
                    <i class="fas fa-sign-in"></i>
                    <span>Đề thường</span>
                </span>
                <span name="3cang" class="category-tab ">
                    <i class="fas fa-sign-out"></i>
                    <span>Đề 3 càng</span>
                </span>
                <span name="odd_even" class="category-tab ">
                    <i class="fas fa-sign-out"></i>
                    <span>Chẵn/Lẻ/Kép/Tài/Xỉu</span>
                </span>
            </div>
            <input type="hidden" id="bet_type" value="de" name="bet_type">
            <br>
            <div class="radio-container" style="margin-bottom: 20px;">
                <label><input checked type="radio" name="coin_type" value="knb"> Xu nạp</label>
                <label><input type="radio" name="coin_type" value="war"> Xu war</label>
            </div>
            <div class="form-grid">
                <div class="form-group" id="number">
                    <input name="number" class="form-control" value="" placeholder="Nhập số dự đoán">
                </div>
                <div class="form-group" id="odd_even" style="display:none;">
                    <select name="odd_even" class="form-control" style="background-color: #000">
                        <option value="odd">Chẵn</option>
                        <option value="even">Lẻ</option>
                        <option value="kep">Kép</option>
                        <option value="tai">Tài</option>
                        <option value="xiu">Xỉu</option>
                    </select>
                </div>

                <div class="form-group">
                    <input placeholder="Bạn muốn cược bao nhiêu?" required name="amount" type="number"
                        class="form-control">
                </div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-primary">Thực hiện</button>
            </div>
        </form>
    </div>
    <div class="security-tips">
        <div class="security-tips-header">
            <i class="fas fa-shield-alt"></i> Kết quả 10 ngày gần nhất
        </div>
        <table>
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Đặc biệt</th>
                    <th>Số đề</th>
                    <th>3 càng</th>
                    <th>Chẵn/lẻ</th>
                    <th>Tài/Xỉu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{\Carbon\Carbon::parse($item["date"])->format("d/m/Y")}}</td>
                    <td>{{$item["giai_db"]}}</td>
                    <td>{{$item["so_de"]}}</td>
                    <td>{{$item["ba_cang"]}}</td>
                    <td>{{$item["odd_even"] == "odd" ? "Chẵn" : "Lẻ"}}</td>
                    <td>{{intval($item["so_de"]) > 49 ? "Tài" : "Xỉu"}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="security-tips">
        <div class="security-tips-header">
            <i class="fas fa-shield-alt"></i> Thể lệ chơi số đề (Miền Bắc)
        </div>
        <ul style="width: 100%;">
            <h4>1. Số đề là gì?</h4>
            <p>Số đề là hình thức cá cược dựa vào <strong>2 chữ số cuối của giải Đặc biệt</strong> trong kết quả xổ số
                miền Bắc.</p>
            <p>Ví dụ: Giải Đặc biệt là <strong>76288</strong> → số đề là <strong>88</strong>.</p>

            <h4>2. Các hình thức đánh đề của mini game</h4>
            <table id="killers-table">
                <thead>
                    <tr>
                        <th>Tên gọi</th>
                        <th>Mô tả</th>
                        <th>Tỷ lệ ăn</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Đề thường</td>
                        <td>Đánh trúng 2 số cuối giải Đặc biệt</td>
                        <td>1 x 95</td>
                    </tr>
                    <tr>
                        <td>Đề 3 càng</td>
                        <td>Đánh trúng 3 số cuối giải Đặc biệt</td>
                        <td>1 x 500</td>
                    </tr>
                    <tr>
                        <td>Chẵn/lẻ</td>
                        <td>Đề là số chẵn hay số lẻ</td>
                        <td>1 x 2</td>
                    </tr>
                    <tr>
                        <td>Kép</td>
                        <td>Đề là số kép 00,11,22...99</td>
                        <td>1 x 10</td>
                    </tr>
                    <tr>
                        <td>Tài</td>
                        <td>Đề là số lớn trong phạm vi (50-99)</td>
                        <td>1 x 2</td>
                    </tr>
                    <tr>
                        <td>Xỉu</td>
                        <td>Đề là số nhỏ trong phạm vi (00-49)</td>
                        <td>1 x 2</td>
                    </tr>
                </tbody>
            </table>

            <h4>3. Quy tắc đặt cược và trao thưởng</h4>
            <p>Chỉ được dự đoán trước 18h00</p>
            <p>Hệ thống tự động trả điểm ngay sau khi có kết quả.</p>
        </ul>
    </div>
    <div class="security-tips">
        <div class="security-tips-header">
            <i class="fas fa-shield-alt"></i> Lịch sử đặt cược của bạn gần đây
        </div>
        <table>
            <thead>
                <tr>
                    <th>Ngày cược</th>
                    <th>Thể loại cược</th>
                    <th>Giá trị</th>
                    <th>Số tiền</th>
                    <th>Tiền thắng</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bets as $item)
                <tr>
                    <td>{{\Carbon\Carbon::parse($item["date"])->format("d/m/Y")}}</td>
                    <td>{{$item->type}}</td>
                    <td>{{$item->value}}</td>
                    <td>{{number_format($item->amount)}}</td>
                    <td>{{number_format($item->prize)}}</td>
                    <td>
                        <button class="btn-claim {{$item->status}}">{{$item->trang_thai}}</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<style>
    /* Table styling */
    .category-tab {
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    thead {
        background-color: rgba(0, 0, 0, 0.3);
        position: sticky;
        top: 0;
    }

    th {
        padding: 12px 15px;
        text-align: left;
        color: var(--accent-color);
        font-weight: 500;
        border-bottom: 1px solid var(--border-color);
        letter-spacing: 1px;
    }

    td {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        transition: all 0.3s ease;
    }

    tbody tr {
        transition: background-color 0.3s ease;
    }

    tbody tr:hover {
        background-color: rgba(212, 175, 55, 0.05);
    }
</style>
<script>
    $('.category-tabs .category-tab').on('click', function () {
        $('.category-tabs .category-tab').removeClass('active');
        $(this).addClass('active');
        const bet_type = $(this).attr("name")
        $("#bet_type").val($(this).attr("name"))
        if (bet_type == "odd_even") {
            $("#number").hide()
            $("#odd_even").show()
        } else {
            $("#number").show()
            $("#odd_even").hide()
        }
    });
</script>
@endsection