@extends('layouts.master')
@section('content')
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-rotate"></i> Đổi môn phái
    </div>

    <div class="security-tips">
        <div class="security-tips-header">
            <i class="fas fa-shield-alt"></i> Một số lưu ý
        </div>
        <ul style="width: 100%;">
            <li>Chuyển đổi môn phái nhân vật <font color="red">{{ Auth::user()->char->getName() }} ({{Auth::user()->char->char_id}})</font></li>
            <li>
                Môn phái hiện tại: <font color="red">{{ Auth::user()->char->getClass() }}</font>
            </li>
            <li>Chi phí: <font color="red">MIỄN PHÍ</font> tới hết ngày 12/07/2025</li>
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