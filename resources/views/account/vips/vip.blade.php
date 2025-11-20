@extends('layouts.master')
@section('content')
<div class="account-section quest" id="transactions-container">
    <div class="account-section-title">
        <i class="fas fa-gift"></i> Danh sách đặc quyền (mỗi ngày nhận được 1 lần)
    </div>
    <table id="killers-table" style="">
        <thead>
            <tr>
                <th class="py-3 px-6 text-left">Vật phẩm</th>
                <th class="py-3 px-6 text-left">Số Lượng</th>
                <th class="py-3 px-6 text-left">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($configs as $item)
            <tr>
                <td class="py-3 px-6 text-left">
                    <div class="flex items-center">
                        {{ ($item["title"]) }}
                    </div>
                </td>
                <td class="py-3 px-6 text-left">
                    <div class="flex items-center">
                        @if(Auth::user()->viplevel >= 6)
                        {{ ($item["data"][Auth::user()->viplevel]) }}
                        @else
                        0
                        @endif
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
                        @if ($item["status"] == "done")
                <button class="btn-claim" disabled="">
                    <i class="fas fa-lock"></i> Đã nhận
                </button>
                @else
                <a href="/vip/{{$item['code']}}/using" class="btn btn-primary">
                    <i class="fa-solid fa-circle-check"></i> Nhận quà
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
            <p>🔹 Cấp VIP khác nhau số lượng sẽ khác nhau, từ VIP 6 trở lên</p>
            <p>🔹 Nhận quà đặc quyền cho nhân vật <strong style="color:red" class="blink-zoom">{{
                    Auth::user()->char ? Auth::user()->char?->getName() : "Chưa có nhân vật" }}</strong></p>
            <p>🔹 Chọn lại nhân vật chính từ màn hình trên cùng</p>
            <p>❌ Hãy chắc chắn rằng bạn đã kiểm tra hộp thư trong game trước mua vật phẩm.</p>
        </ul>
    </div>
</div>
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-gift"></i> Danh sách vật phẩm đặc quyền VIP
    </div>

    <table id="killers-table">
        <thead>
            <tr>
                <th class="py-3 px-6 text-left">Vật phẩm</th>
                <th class="py-3 px-6 text-left">Số Lượng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($configs as $item)
            <tr>
                <td>{{ $item["title"] }}</td>
                <td>
                    <ul>
                        @foreach ($item["data"] as $level => $quantity)
                        <li><span class="vip lvl{{$level}}"></span> {{ $quantity }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection