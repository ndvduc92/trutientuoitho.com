@extends('account.layouts.master')
@section('content')

<h1 class="h3 mb-3">Danh sách Giftcode</h1>
<div class="tab-content">
    <div class="tab-pane fade show active" id="account" role="tabpanel">

        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                    <div class="alert-message">
                        <h4 class="alert-heading">⛔ Một số lưu ý</h4>
                        <p class="text-primary fw-bold">
                        ❌ Chọn lại nhân vật nhận giftcode từ menu trên cùng <span class="text-danger fw-bold">[{{Auth::user()->char ? Auth::user()->char?->getName() : "Chưa có nhân vật" }}]</span><br>
                        ❌ Hãy chắc chắn rằng bạn đã kiểm tra hộp thư trong game trước khi nhận quà.<br>
                        ❌ Mỗi tài khoản chỉ được nhận duy nhất một lần.
                    </p>

                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:40%;">Giftcode</th>
                            <th style="width:25%">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($giftcodes as $item)
                        <tr>
                            <td>{{ ($item->giftcode) }}</td>
                            <td class="d-none d-md-table-cell">
                                <div class="flex items-center">
                        @if ($item->beUsedByUser())
                        <button class="btn btn-secondary" disabled="">
                            <i class="fas fa-lock"></i> Đã sử dụng
                        </button>
                        @else
                        <a href="/account/giftcodes/{{ $item->id }}/using" class="btn btn-success">
                            <i class="fa-solid fa-circle-check"></i> Sử dụng
                        </a>
                        @endif
                    </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection