@extends('layouts.master')
@section('content')
<div class="main-content" style="background: #fff">
    <!-- Referral Overview -->
    <div class="dashboard-section">
        <div class="account-section-title">
            Nạp Tiền
        </div>
        <div style="margin-top: 20px;">

            <div class="p-2">
                <table style="width: 100%; height: auto; padding: 2px 0 0 0;">
                    <tbody>

                        <tr align="center" valign="middle" style="text-align: center">


                            <td colspan="2" style="text-align: center">
                                <img style="display: inline" src="{{$img}}" alt="" width="50%" id="chuyenkhoanmbbank">
                            </td>

                            <!-- <td style="text-align: center" ><font color="red"> MB-BANK ĐANG BẢO TRÌ... </font></td> -->


                        </tr>
                        <div class="security-tips" style="margin-bottom: 10px">
                            <ul style="width: 100%;">
                                <p>⚠️ Một khi đã nạp sẽ không hoàn trả dưới bất kỳ lý do nào.</p>
                                <p>🔄 Trải nghiệm trò chơi trước khi tự nguyện quyết định nạp xu.</p>
                                <p>📷 Quét mã QR để tự động điền thông tin mã nạp tiền.</p>
                                <p>💰 Tỉ lệ nạp (chưa bao gồm khuyến mãi): 1000 VNĐ = 1000 XU</p>
                                <p style="color:red;">🌿 Khuyến mãi hiện tại:
                                    {{$currentPromotion->type
                                    == "double" ? "x".$currentPromotion->amount :
                                    $currentPromotion->amount."%"}}</p>
                            </ul>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Your Referral Code -->
    <div class="dashboard-section">
        <h4 class="transactions-title">
            <span><i class="fas fa-history"></i> Lịch sử nạp</span>
        </h4>
        <div class="transactions-list" id="transactions-container">
            <table id="killers-table">
                <thead>
                    <tr>
                        <th class="py-3 px-6 text-left">Số tiền</th>
                        <th class="py-3 px-6 text-left">Xu nhận được</th>
                        <th class="py-3 px-6 text-left">Xu (sau KM)</th>
                        <th class="py-3 px-6 text-left">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $item)
                    <tr>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                {{ number_format($item->amount) }}đ
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                {{ number_format($item->amount) }}
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                {{ number_format($item->amount_promotion) }}
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                {{ \Carbon\Carbon::parse($item->processing_time)->format("d/m/Y H:i:s") }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr style="background:#1baac2">
                        <td></td>
                        <td></td>
                        <td>Tổng cộng</td>
                        <td>{{number_format($sum)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection