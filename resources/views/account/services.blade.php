@extends('layouts.master')
@section('content')

<div class="rewards-grid quest">
    <div class="reward-card">
        <div class="reward-header">
            <h4 class="reward-name">Cập nhật VIP</h4>
        </div>

        <div class="reward-body">
            <p class="reward-description">
                Khi cấp VIP khác với số KNB đã nạp</p>

            <div class="reward-items">
                Yêu cầu:
                <p>- Nhân vật phải offline</p>
                <p>- Miễn phí</p>
                <p></p>
            </div>

            <!-- Action buttons -->
            <div class="reward-actions">

                <a href="/dich-vu/cap-nhat-vip" class="btn-claim">
                    <i class="fas fa-lock"></i> Cập Nhật
                </a>
            </div>

        </div>
    </div>
    <div class="reward-card">
        <div class="reward-header">
            <h4 class="reward-name">Gia hạn VIP</h4>
        </div>

        <div class="reward-body">
            <p class="reward-description">
                Khi cấp VIP hết hạn</p>

            <div class="reward-items">
                Yêu cầu:
                <p>- Nhân vật phải offline</p>
                <p>- Duy trì số dư: {{number_format($need)}} xu</p>
            </div>

            <!-- Action buttons -->
            <div class="reward-actions">

                <a href="/dich-vu/gia-han-vip" class="btn-claim">
                    <i class="fas fa-lock"></i> Gia hạn
                </a>
            </div>

        </div>
    </div>
</div>
@endsection