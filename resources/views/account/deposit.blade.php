@extends('account.layouts.master')
@section('content')
<h1 class="h3 mb-3">Nạp Tiền</h1>
<div class="tab-content">
    <div class="tab-pane fade show active" id="account" role="tabpanel">

        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img style="display: inline" src="{{$img}}" alt="" width="50%">
                </div>
                <div class="alert alert-danger" role="alert">
                    <div class="alert-message">
                        <h4 class="alert-heading">⛔ Một số lưu ý</h4>
                        <p class="text-danger fw-bold">
                        ✔️ Một khi đã nạp sẽ không hoàn trả dưới bất kỳ lý do nào.<br>
                        ✔️ Quét mã QR ở trên để tự động điền nội dung mã giao dịch.<br>
                        <span class="text-danger fw-bold">✔️ Nạp mệnh giá dưới 10.000 VNĐ sẽ không nhận được xu.</span><br>
                    </p>

                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">

                <h5 class="card-title mb-0">Lịch Sử Nạp Tiền</h5>
            </div>
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:40%;">Số tiền</th>
                            <th style="width:25%">Xu nhận được</th>
                            <th class="d-none d-md-table-cell" style="width:25%">Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $item)
                        <tr>
                            <td>{{ number_format($item->amount) }}đ</td>
                            <td>{{ number_format($item->amount_promotion) }}</td>
                            <td class="d-none d-md-table-cell">{{
                                \Carbon\Carbon::parse($item->processing_time)->format("d/m/Y H:i:s") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection