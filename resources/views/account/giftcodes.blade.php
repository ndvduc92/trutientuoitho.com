@extends('layouts.master')
@section('content')
@include('auth.chars')
<div class="account-section quest" id="transactions-container">
    <div class="account-section-title">
        <i class="fas fa-gift"></i> Danh sách Giftcode
    </div>
    <table id="killers-table" style="">
        <thead>
            <tr>
                <th class="py-3 px-6 text-left">Tên giftcode</th>
                {{-- <th class="py-3 px-6 text-left">Vật phẩm</th> --}}
                <th class="py-3 px-6 text-left">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($giftcodes as $item)
            <tr>
                <td class="py-3 px-6 text-left">
                    <div class="flex items-center">
                        {{ ($item->giftcode) }}
                    </div>
                </td>
                {{-- <td class="py-3 px-6 text-left">
                    <div class="flex items-center">
                        @foreach ($item->items as $it)
                        <div class="reward-item">
                            <div class="reward-item-icon">
                                <img src="{{ $it->item->image }}">
                            </div>
                                {{ $it->item->name }} (x{{$it->quantity }})
                        </div>
                        @endforeach
                    </div>
                </td> --}}
                <td class="py-3 px-6 text-left">
                    <div class="flex items-center">
                        @if ($item->beUsedByUser())
                <button class="btn-claim" disabled="">
                    <i class="fas fa-lock"></i> Đã nhận
                </button>
                @else
                <a href="/giftcodes/{{ $item->id }}/using" class="btn btn-primary">
                    <i class="fa-solid fa-circle-check"></i> Sử dụng
                </a>
                @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <div class="security-tips">
        <ul style="width: 100%;">
            <p>🔹 Nhận giftcode cho nhân vật <strong style="color:red" class="blink-zoom">{{
                    Auth::user()->char ? Auth::user()->char?->getName() : "Chưa có nhân vật" }}</strong></p>
            <p>🔹 Chọn lại nhân vật chính từ màn hình trên cùng</p>
            <p>❌ Hãy chắc chắn rằng bạn đã kiểm tra hộp thư trong game trước khi nhận quà. !</p>
        </ul>
    </div>
</div>
@endsection