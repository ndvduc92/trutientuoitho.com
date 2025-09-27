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
<style>
    /* Main content */
    .main-content {
        display: flex;
        flex-direction: column;
    }

    .section-title {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title h2 {
        margin: 0;
        font-size: 2rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .decorative-line {
        flex: 1;
        height: 2px;
        background: #1baac2;
        margin-left: 20px;
        opacity: 0.5;
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

    /* Category tabs (like in the stash page) */
    .shop-categories {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        margin-bottom: 20px;
    }

    .category-tabs {
        display: flex;
        border-bottom: 1px solid var(--border-color);
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
        scrollbar-color: var(--accent-color) rgba(0, 0, 0, 0.3);
    }

    .category-tabs::-webkit-scrollbar {
        height: 4px;
    }

    .category-tabs::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.3);
    }

    .category-tabs::-webkit-scrollbar-thumb {
        background-color: var(--accent-color);
        border-radius: 20px;
    }

    .category-tab {
        padding: 12px 20px;
        color: var(--text-color);

        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .category-tab:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
    }

    .category-tab.active {
        background: rgba(212, 175, 55, 0.15);
        color: var(--accent-color);
        box-shadow: inset 0 -2px 0 var(--accent-color);
    }

    /* View toggle (Grid/List) */
    .view-controls {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }

    .view-toggle {
        display: flex;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        overflow: hidden;
    }

    .view-toggle a {
        display: flex;
        align-items: center;
        padding: 8px 15px;
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .view-toggle a i {
        margin-right: 5px;
    }

    .view-toggle a:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
    }

    .view-toggle a.active {
        background: rgba(212, 175, 55, 0.15);
        color: var(--accent-color);
    }

    /* Shop container - grid and item preview */
    .shop-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    /* Shop grid */
    .shop-grid-container {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;

        box-shadow: 0 0 10px rgba(140, 255, 193, 0.3);
    }

    .shop-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 15px;
    }

    /* Shop item styling (to match stash.php) */
    .shop-item {
        background-color: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        height: 130px;
    }

    .shop-item:hover {
        border-color: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3), 0 0 5px var(--accent-glow);
    }

    .shop-item.active {
        border-color: var(--accent-color);
        box-shadow: 0 0 10px var(--accent-glow);
        background-color: rgba(212, 175, 55, 0.1);
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

    .item-info {
        width: 100%;
        text-align: center;
    }

    .item-name {
        font-size: 0.85rem;
        color: var(--text-color);
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }

    .item-label {
        display: inline-block;
        background-color: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 3px;
        margin-bottom: 5px;
    }

    .item-label i {
        margin-left: 2px;
        font-size: 0.65rem;
    }

    .quantity-label {
        font-size: 0.75rem;
        color: #2ecc71;
        font-weight: 600;
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

    .price-display {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 10px 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-label {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .price-value {
        display: flex;
        align-items: center;
        font-size: 1rem;
        color: var(--accent-color);
        font-weight: 600;
    }

    .price-value i {
        margin-left: 5px;
    }

    /* Quantity selector */
    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .quantity-label {
        margin-right: 10px;
        color: var(--text-muted);
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        overflow: hidden;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        background-color: rgba(0, 0, 0, 0.3);
        border: none;
        color: var(--text-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        background-color: rgba(212, 175, 55, 0.2);
        color: var(--accent-color);
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        border: none;
        border-left: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color);
        background-color: rgba(0, 0, 0, 0.2);
        color: var(--text-color);
        height: 30px;
        font-size: 0.9rem;
    }

    .quantity-input:focus {
        outline: none;
        background-color: rgba(0, 0, 0, 0.4);
    }

    /* Purchase button */
    .purchase-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--button-gradient);
        color: var(--primary-bg);
        font-weight: bold;
        border: none;
        border-radius: 5px;
        padding: 12px 0;
        cursor: pointer;
        transition: all 0.3s ease;

        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .purchase-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .purchase-button i {
        margin-right: 8px;
    }

    /* No items message */
    .no-items-message {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        color: var(--text-muted);
        text-align: center;
    }

    .no-items-message i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--border-color);
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

    /* Responsive layout */
    @media (max-width: 1200px) {
        .shop-dashboard {
            width: 95%;
        }
    }

    @media (max-width: 992px) {
        .shop-dashboard {
            grid-template-columns: 1fr;
        }

        .sidebar {
            display: none;
        }

        .shop-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .shop-stats {
            width: 100%;
        }

        .shop-container {
            grid-template-columns: 1fr;
        }

        .item-preview {
            position: static;
            margin-top: 20px;
        }
    }

    @media (max-width: 768px) {
        .shop-items-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }

        .shop-header {
            flex-direction: column;
        }

        .shop-stats {
            margin-top: 10px;
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
</style>
<div class="account-section">
    <a href="" class="account-section-title">
        <i class="fa-solid fa-briefcase"></i> Thông tin nhân vật: [{{$char->name}}]
    </a>
    <style>
        /* Slot cơ bản */
        .equipment-slot {
            position: relative;
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            overflow: visible;
        }

        /* Vòng sáng halo */
        .equipment-slot.high-refine::before,
        .equipment-slot.high-refine::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: radial-gradient(rgba(255, 215, 0, 0.6), transparent);
            transform: translate(-50%, -50%) scale(0.8);
            animation: halo 2s infinite linear;
            z-index: 1;
        }

        .equipment-slot.high-refine::after {
            animation-delay: 1s;
            /* Lệch pha vòng 2 */
        }

        /* Halo animation */
        @keyframes halo {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.7;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.8);
                opacity: 0;
            }
        }
    </style>
    <div style="margin-top:50px">
        <div class="shop-container">
            <!-- Shop items grid -->
            <div class="shop-grid-container">
                <div class="character-ui">
                    <div class="char-image" style="background: url('{{$char->image}}') center/contain no-repeat;">
                    </div>

                    <div style="background-image:url({{ getImageSlot($equipmentData, 1)}})"
                        class="equipment-slot high-refine slot slot-1"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 2)}})" class="slot slot-2"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 3)}})" class="slot slot-3"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 4)}})" class="slot slot-4"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 5)}})" class="slot slot-5"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 6)}})" class="slot slot-6"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 0)}})" class="slot slot-7"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 14)}})" class="slot slot-8"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 9)}})" class="slot slot-9"></div>

                    <div style="background-image:url({{ getImageSlot($fashionData, 0)}})" class="slot slot-10"></div>
                    <div style="background-image:url({{ getImageSlot($fashionData, 1)}})" class="slot slot-11"></div>
                    <div style="background-image:url({{ getImageSlot($fashionData, 2)}})" class="slot slot-12"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 7)}})" class="slot slot-13"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 19)}})" class="slot slot-14"></div>
                    <div style="" class="slot slot-15"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 26)}})" class="slot slot-16"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 27)}})" class="slot slot-17"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 23)}})" class="slot slot-18"></div>

                    <div style="background-image:url({{ getImageSlot($equipmentData, 16)}})" class="slot slot-19"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 17)}})" class="slot slot-20"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 18)}})" class="slot slot-21"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 15)}})" class="slot slot-22"></div>

                    <div style="background-image:url({{ getImageSlot($equipmentData, 22)}})" class="slot slot-23"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 12)}})" class="slot slot-24"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 21)}})" class="slot slot-25"></div>
                    <div style="background-image:url({{ getImageSlot($equipmentData, 20)}})" class="slot slot-26"></div>
                </div>
            </div>
            <style>
                .character-info {
                    background: rgba(255, 255, 255, 0.05);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    border-radius: 12px;
                    padding: 20px;
                    color: #c3f4c1;
                    font-family: 'Segoe UI', sans-serif;
                    font-size: 15px;
                    width: 260px;
                    line-height: 1.7;
                    box-shadow: 0 0 10px rgba(140, 255, 193, 0.3);
                }

                .character-info .row {
                    margin-bottom: 10px;
                    padding: 8px 12px;
                    background: rgba(0, 0, 0, 0.25);
                    border-radius: 8px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .character-info .row strong {
                    color: #9cf;
                    min-width: 100px;
                    display: inline-block;
                }

                .character-info .faction-icon {
                    width: 18px;
                    height: 18px;
                    vertical-align: middle;
                    margin-right: 6px;
                }

                .character-info .row:hover {
                    background-color: rgba(100, 255, 180, 0.1);
                    box-shadow: 0 0 6px rgba(100, 255, 180, 0.5);
                    transition: all 0.3s ease;
                }

                /* Online glowing green */
                .status-online {
                    color: #00ff7f;
                    font-weight: bold;
                    position: relative;
                    padding-left: 20px;
                }

                .status-online::before {
                    content: "";
                    position: absolute;
                    left: 0;
                    top: 6px;
                    width: 10px;
                    height: 10px;
                    background: #00ff7f;
                    border-radius: 50%;
                    box-shadow: 0 0 8px #00ff7f;
                    animation: pulseGreen 1.2s infinite ease-in-out;
                }

                /* Offline red static dot */
                .status-offline {
                    color: #ff4d4d;
                    font-weight: bold;
                    position: relative;
                    padding-left: 20px;
                }

                .status-offline::before {
                    content: "";
                    position: absolute;
                    left: 0;
                    top: 6px;
                    width: 10px;
                    height: 10px;
                    background: #ff4d4d;
                    border-radius: 50%;
                    box-shadow: 0 0 5px #ff4d4d;
                }

                @keyframes pulseGreen {
                    0% {
                        transform: scale(1);
                        opacity: 1;
                    }

                    50% {
                        transform: scale(1.4);
                        opacity: 0.5;
                    }

                    100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }

                .char {
                    font-weight: bold;
                    color: #e74c3c;
                }
            </style>
            <!-- Item preview panel -->
            <div class="character-info">
                <div class="row"><strong>Nhân vật: <span class="char">{{$char->name}}</span></strong></div>
                <div class="row"><strong>Môn phái: <span class="char">{!! $char->class_icon
                            !!}{{$char->getClass()}}</span></strong></div>
                <div class="row"><strong>Trạng thái:</strong> <span class="status-{{isRoleOnline($char->char_id) ? "
                        online" : "offline" }}">{{isRoleOnline($char->char_id) ? "Online" : "Offline" }}</span></div>
                <div class="row"><strong>HP: <span class="char">{{$info["hp"]}}</span></strong></div>
                <div class="row"><strong>MP: <span class="char">{{$info["mp"]}}</span></strong></div>
            </div>
        </div>



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
                background: #1a1a1a;
                padding: 16px;
                border-radius: 8px;
                width: fit-content;
            }

            .bag-slot {
                position: relative;
                width: 50px;
                height: 50px;
                border: 2px solid #555;
                background: #000;
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
        {{-- @foreach ($equipmentData2 as $xx)
        <div class="bag-grid">
            @foreach ($xx as $item)
            <div class="bag-slot vip-glow quality-legendary" title="{{$item['name']}}">
                <img src="{{$item['image']}}" />
                <div class="bag-count">{{$item['pos']}}</div>
            </div>
            @endforeach
        </div>
        @endforeach

        @foreach ($fashionData as $xx)
        <div class="bag-grid">
            @foreach ($xx as $item)
            <div class="bag-slot vip-glow quality-legendary" title="{{$item['name']}}">
                <img src="{{$item['image']}}" />
                <div class="bag-count">{{$item['pos']}}</div>
            </div>
            @endforeach
        </div>
        @endforeach --}}

    </div>
</div>
@endsection