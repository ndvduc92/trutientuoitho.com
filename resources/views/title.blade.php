@extends('layouts.master')
@section('content')
<style>
    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    thead {
        background-color: rgba(0, 0, 0, 0.3);
        position: sticky;
        top: 0;
    }

    th {
        padding: 12px 15px;
        text-align: left;
        color: var(--accent-color);
        font-weight: 500;
        border-bottom: 1px solid var(--border-color);
        letter-spacing: 1px;
    }

    td {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        transition: all 0.3s ease;
    }

    tbody tr {
        transition: background-color 0.3s ease;
    }

    tbody tr:hover {
        background-color: rgba(212, 175, 55, 0.05);
    }
    
    .invalid {
       text-decoration: line-through;
    }
</style>
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-rotate"></i> Đặt danh hiệu riêng
    </div>

    <div class="security-tips">
        <div class="security-tips-header">
            <i class="fas fa-shield-alt"></i> Một số lưu ý
        </div>
        <ul style="width: 100%;">
            <li>Tôn hiệu trong game giới hạn từ 2 đến 5 chữ</li>
            <li>
                Tôn hiệu sẽ được trao vào bản cập nhật kế tiếp.
            </li>
            <li>
                Không chấp nhận những tôn hiệu mang tính CÔNG KÍCH CÁ NHÂN.
            </li>
            <li>Chi phí: <font color="red">200000 xu/tôn hiệu</font>
            </li>
        </ul>
    </div>

    <form id="contact-form" action="" method="post" style="margin-top: 20px;">
        @csrf
        <div class="form-group character-dropdown">
            <input name="title" class="form-control" placeholder="Nhập tôn hiệu 2-6 chữ">
        </div>
        <br>
        <fieldset>
            <legend>Lựa chọn màu sắc:</legend>
            @foreach (\App\Models\Title::COLORS as $key => $value)
            <div>
                <input type="radio" id="huey" name="color" value="{{$value}}" />
                <label for="huey" style="color: {{$value}} !important">{{$key}}</label>
            </div>
            @endforeach
        </fieldset>
        <br>
        <div class="col-4">
            <button type="submit" class="btn btn-primary">Đăng Ký</button>
        </div>
    </form>
</div>
<div class="account-section">
    <table id="killers-table">
        <thead>
            <tr>
                <th>Nhân vật</th>
                <th>Tôn Hiệu</th>
                <th>Mã màu</th>
                <th>Trạng Thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($titles as $item)
            <tr>
                <td class="player-name">{{$item->char->name}}</td>
                <td class="{{ $item->status == 'invalid' ? 'invalid' : ''}}" style="color:{{$item->color}}">{{ $item->title }}</td>
                <td class="rank-column top-rank" style="color:{{$item->color}}">{{ $item->color }}</td>
                <td>{{ \App\Models\Title::STATUSES[$item->status] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection