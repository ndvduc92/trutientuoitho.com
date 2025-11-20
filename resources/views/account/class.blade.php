@extends('layouts.master')
@section('content')
@include('auth.chars')
<div class="account-section">
    <div class="account-section-title">
        Đổi môn phái
    </div>

    <div class="security-tips">
        <ul style="width: 100%;">
            <p>🔹 Chuyển đổi môn phái nhân vật <strong style="color:red" class="blink-zoom">{{
                    Auth::user()->char ? Auth::user()->char?->getName() : "Chưa có nhân vật" }}</strong></p>
            <p>🔹 Chọn lại nhân vật chính từ màn hình trên cùng</p>
            <p>🔹 Chi phí: <font color="red">100,000</font> xu cho 1 lần đổi môn phái</p>
            <p>🔄 Người chơi có thể tự đổi Tiền Kiếp trong game bằng cách mang vật phẩm Dịch Hồn Cải Mệnh thư tìm tới
                NPC Huyễn Hồn Tiên Tử tiến hành đổi tiền kiếp.</p>
            <p>❌ Đổi môn phái không bao gồm tự động đổi set trang bị, người chơi phải tự up trang bị lại từ đầu!</p>
            <p>❌ Chỉ đổi class không hỗ trợ gì cả !</p>
        </ul>
    </div>

    <form id="contact-form" action="" method="post" style="margin-top: 20px;">
        @csrf
        <div class="form-group character-dropdown">
            <select name="class" id="coin_type" class="form-control" style="padding: 12px 15px;" required>
                @foreach (\App\Models\Char::CLASS_ITEM as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary">Đổi môn phái</button>
        </div>
    </form>
</div>
@endsection