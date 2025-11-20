@extends('layouts.master')
@section('content')
<style>
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
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px var(--shadow-color);
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

    .section-title h2 {
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

    /* VIP Level Display */
    .vip-level-section {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px var(--shadow-color);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    /* Different gradients for each VIP level */
    .vip-level-1 {
        --vip-gradient: linear-gradient(135deg, #C0C0C0, #808080, #696969);
        --vip-glow: rgba(192, 192, 192, 0.6);
    }

    .vip-level-2 {
        --vip-gradient: linear-gradient(135deg, #B87333, #8B4513, #D2691E);
        --vip-glow: rgba(184, 115, 51, 0.6);
    }

    .vip-level-3 {
        --vip-gradient: linear-gradient(135deg, #228B22, #32CD32, #00FF00);
        --vip-glow: rgba(34, 139, 34, 0.6);
    }

    .vip-level-4 {
        --vip-gradient: linear-gradient(135deg, #4169E1, #1E90FF, #00BFFF);
        --vip-glow: rgba(65, 105, 225, 0.6);
    }

    .vip-level-5 {
        --vip-gradient: linear-gradient(135deg, #9400D3, #8A2BE2, #DA70D6);
        --vip-glow: rgba(148, 0, 211, 0.6);
    }

    .vip-level-6 {
        --vip-gradient: linear-gradient(135deg, #FFD700, #FFA500, #FF6347);
        --vip-glow: rgba(255, 215, 0, 0.6);
    }

    .vip-badge {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        padding: 15px 30px;
        background: var(--vip-gradient);
        border-radius: 50px;
        position: relative;
        animation: vipGlow 2s ease-in-out infinite;
        box-shadow:
            0 0 20px var(--vip-glow),
            0 0 40px var(--vip-glow),
            0 0 60px var(--vip-glow);
    }

    .vip-progress {
        margin-top: 20px;
    }

    .vip-progress-bar {
        width: 100%;
        height: 20px;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .vip-progress-fill {
        height: 100%;
        background: var(--vip-gradient);
        transition: width 0.5s ease;
    }

    /* Promo code section */
    .promo-code-section {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px var(--shadow-color);
        position: relative;
        overflow: hidden;
    }

    .promo-code-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, var(--accent-glow) 0%, transparent 60%);
        opacity: 0.05;
        pointer-events: none;
    }

    .promo-code-title {
        display: flex;
        align-items: center;
        font-size: 1.3rem;
        color: var(--accent-color);
        margin-bottom: 20px;

    }

    .promo-code-title i {
        margin-right: 15px;
        font-size: 1.5rem;
    }

    .promo-code-form {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .promo-code-input {
        flex: 1;
        padding: 12px 20px;
        background-color: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        color: var(--text-color);
        font-size: 1rem;

        letter-spacing: 2px;
        text-transform: uppercase;
        transition: all 0.3s ease;
    }

    .promo-code-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
    }

    .promo-code-input::placeholder {
        color: var(--text-muted);
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

        .section-title h2 {
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

<!--<div id="error-alert" class="alert alert-danger" style="">-->
<!--                <i class="fas fa-warning alert-icon"></i>-->
<!--                <span id="error-message">Lưu ý: Nếu đã hoàn thành nhiệm vụ trong game mà vẫn không được, bấm <a href="?refresh=yes">VÀO ĐÂY</a> để cập nhật lại dữ liệu</span>-->
<!--            </div>-->
<div class="rewards-grid">
    @foreach ($quests as $item)
    <div class="reward-card">
        <div class="reward-header">
           
            <h4 class="reward-name">{{ $item->name }}</h4>
        </div>

        <div class="reward-body">
            <div class="reward-requirement requirement-not-met">
                <i class="fas fa-coins"></i>Xu web: {{ $item->xu }}
            </div>
            <div class="reward-items">

                @foreach ($item["items"] as $it)
                <div class="reward-item">
                    <div class="reward-item-icon">
                        <img src="{{$it->image}}">
                    </div>

                    <span class="reward-item-name">
                        {{ $it->item->name }} </span>
                    <span class="reward-item-quantity">x{{$it["quantity"] }}</span>
                </div>
                @endforeach
            </div>

            <!-- Action buttons -->
            <div class="reward-actions">
                @if ($item->beDoneByUser())
                <button class="btn-claim" disabled="">
                    <i class="fas fa-lock"></i> Đã làm
                </button>
                @else
                <a href="/nhiem-vu/{{ $item[" id"] }}/using" class="btn-claim">
                    <i class="fa-solid fa-circle-check"></i> Làm nhiệm vụ
                </a>
                @endif

            </div>

        </div>
    </div>
    @endforeach
</div>

@endsection