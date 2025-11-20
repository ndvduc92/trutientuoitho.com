@extends('account.layouts.master')
@section('content')

<h1 class="h3 mb-3">Đổi Xu Vào Game</h1>
<div class="tab-content">
    <div class="tab-pane fade show active" id="account" role="tabpanel">

        <div class="card">
            <div class="card-body">
                <form id="contact-form" action="" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-form-label col-sm-2 text-sm-start">Xu hiện có</label>
                        <div class="col-sm-10">
                            <input disabled type="email" class="form-control form-control-lg"
                                value="{{Auth::user()->balance}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-form-label col-sm-2 text-sm-start">Số xu cần chuyển</label>
                        <div class="col-sm-10">
                            <input type="number" name="xu" class="form-control form-control-lg">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-form-label col-sm-2 text-sm-start"></label>
                        <div class="col-sm-10">
                            <i class="fas fa-info-circle"></i> Tỉ lệ: 1000 xu = 1 KNB
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="btn btn-success btn-lg">Đổi KNB</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">

                <h5 class="card-title mb-0">Lịch Sử Đổi KNB</h5>
            </div>
            <div class="card-body">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:40%;">Số xu</th>
                            <th style="width:25%">KNB nhận được</th>
                            <th class="d-none d-md-table-cell" style="width:25%">Ngày đổi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($knbs as $item)
                        <tr>
                            <td>{{ number_format($item->getCoinValue()) }}đ</td>
                            <td>{{ number_format(($item->knb_amount)) }}</td>
                            <td class="d-none d-md-table-cell">{{
                                \Carbon\Carbon::parse($item->created_at)->format("d/m/Y H:i:s") }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection