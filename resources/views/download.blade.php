@extends('layouts.master')

@section('content')
<style>
    .reward_item {
        width: 40px;
        height: 40px;
        float: left;
        margin: 2px;
        position: relative;
    }

    .reward_item span {
        position: absolute;
        bottom: 6px;
        left: 6px;
        color: white;
        font-size: 11px;
        text-shadow: 0px 0px 2px #000, 0px 0px 2px #000, 0px 0px 2px #000, 0px 0px 2px #000;
    }
</style>
<style>
    .character-ui {
        position: relative;
        width: auto;
        height: 600px;
    }

    .char-image {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 50%;
        height: 380px;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    .slot {
        position: absolute;
        width: 48px;
        height: 48px;
        border: 2px solid #888;
        border-radius: 6px;
        background-color: rgba(255, 255, 255, 0.05);
        background-size: cover;
        background-position: center;
    }

    /* Trái (slot 1–9) */
    .slot-1 {
        top: 40px;
        left: 20px;
    }

    .slot-2 {
        top: 100px;
        left: 20px;
    }

    .slot-3 {
        top: 160px;
        left: 20px;
    }

    .slot-4 {
        top: 220px;
        left: 20px;
    }

    .slot-5 {
        top: 280px;
        left: 20px;
    }

    .slot-6 {
        top: 340px;
        left: 20px;
    }

    .slot-7 {
        top: 400px;
        left: 20px;
    }

    .slot-8 {
        top: 460px;
        left: 20px;
    }

    .slot-9 {
        top: 520px;
        left: 20px;
    }

    /* Phải (slot 10–18) */
    .slot-10 {
        top: 40px;
        right: 20px;
    }

    .slot-11 {
        top: 100px;
        right: 20px;
    }

    .slot-12 {
        top: 160px;
        right: 20px;
    }

    .slot-13 {
        top: 220px;
        right: 20px;
    }

    .slot-14 {
        top: 280px;
        right: 20px;
    }

    .slot-15 {
        top: 340px;
        right: 20px;
    }

    .slot-16 {
        top: 400px;
        right: 20px;
    }

    .slot-17 {
        top: 460px;
        right: 20px;
    }

    .slot-18 {
        top: 520px;
        right: 20px;
    }

    /* Trên (slot 19–22) */
    .slot-19 {
        top: 10px;
        left: 140px;
    }

    .slot-20 {
        top: 10px;
        left: 200px;
    }

    .slot-21 {
        top: 10px;
        left: 260px;
    }

    .slot-22 {
        top: 10px;
        left: 320px;
    }

    /* Dưới (slot 23–26) */
    .slot-23 {
        top: 520px;
        left: 140px;
    }

    .slot-24 {
        top: 520px;
        left: 200px;
    }

    .slot-25 {
        top: 520px;
        left: 260px;
    }

    .slot-26 {
        top: 520px;
        left: 320px;
    }

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
</style>

<style>
    body {
        background: #0f0f1a;
        padding: 20px;
        font-family: sans-serif;
    }

    .bag-grid {
        display: grid;
        grid-template-columns: repeat(6, 64px);
        gap: 10px;
        padding: 16px;
        border-radius: 8px;
        width: fit-content;
    }

    .bag-slot {
        position: relative;
        width: 50px;
        height: 50px;
        border: 2px solid #555;
        border-radius: 6px;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .bag-slot img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .bag-count {
        position: absolute;
        bottom: 2px;
        right: 3px;
        font-size: 12px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 0 5px;
        border-radius: 4px;
    }

    .quality-common {
        border-color: #777;
    }

    .quality-rare {
        border-color: #1e90ff;
    }

    .quality-epic {
        border-color: #a64efc;
    }

    .quality-legendary {
        border-color: #ff9900;
    }

    .bag-slot:hover {
        border-color: gold;
    }
</style>

<div class="account-section">
    <a href="" class="account-section-title">
        <i class="fa-solid fa-briefcase"></i> Tải client mới
    </a>
    <div style="margin-top:50px">
        <h4><a target="_blank" style="color:green"
                href="https://trutienvietnam.com/tai-game?account={{Auth::user()->id}}">Nhấp vào đây</a> để tải client
            mới. Lưu ý nếu bạn tải game từ đây mới tự động nhận được giftcode</h4>
    </div>
</div>
@endsection