@extends('layouts.master')
@section('content')
<style>
    .chars-list {
        display: none
    }

    #contact-form .form-control {
        margin-top: 5px;
    }
</style>
<div class="account-section">
    <div class="account-section-title">
        Đổi KNB vào game
    </div>

    <form id="contact-form" action="" method="post">
        @csrf
        <div class="form-group" hidden>
            <select name="type" id="coin_type" class="form-control" style="padding: 12px 15px;" required>
                <option value="knb">---Chọn loại xu---</option>
                <option selected value="knb">Xu nạp</option>
                <option value="war">Xu war</option>
            </select>
        </div>
            <div class="form-group">
                <input type="" id="donation_dollars" name="cash" type="number" step="1000" min="0" class="form-control"
                    required="" placeholder="Nhập số xu cần chuyển đổi vào game">
                <div class="form-info">
                    <i class="fas fa-info-circle"></i> Tỉ lệ: 1000 xu = 3KNB
                </div>
            </div>

            {{-- <div class="form-group">
                <label for="real_name">KNB nhận: <b style="color:red;" id="donation_tokens"></b></label>
            </div> --}}

        <div class="">
            <button type="submit" class="btn btn-primary">Đổi KNB</button>
        </div>
    </form>
</div>

<div class="account-section">
    <div class="account-section-title">
        Lịch sử đổi KNB&nbsp;<span style="color:red"></span>
    </div>

    <table id="killers-table">
        <thead>
            <tr>
                <th class="py-3 px-6 text-left">Loại xu</th>
                <th class="py-3 px-6 text-left">Giá trị</th>
                <th class="py-3 px-6 text-left">KNB nhận</th>
                <th class="py-3 px-6 text-left">Ngày đổi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($knbs as $item)
            <tr>
                <td>{{ $item->getCoinType() }}</td>
                <td>{{ number_format(($item->getCoinValue())) }}</td>
                <td>{{ number_format(($item->knb_amount)) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</td>
            </tr>
            @endforeach
            <tr style="background:#1baac2">
                <td></td>
                <td></td>
                <td>Tổng cộng</td>
                <td>{{$sum}}</td>
            </tr>
        </tbody>
    </table>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $("#donation_dollars").change(function() {
        const type = $("#coin_type").val();
        if (type === "knb") {
            $("#donation_tokens").html(($(this).val() / 1000) * 3)
        } else if (type === "war") {
            $("#donation_tokens").html(($(this).val()) * 3)
        } else {
            $("#donation_tokens").html(0)
        }
    })

    $("#coin_type").change(function() {
        const type = $("#coin_type").val();
        if (type === "knb") {
            $("#donation_tokens").html(($("#donation_dollars").val() / 1000) * 3)
        } else if (type === "war") {
            $("#donation_tokens").html(($("#donation_dollars").val()) * 3)
        } else {
            $("#donation_tokens").html(0)
        }
    })
</script>
@endsection