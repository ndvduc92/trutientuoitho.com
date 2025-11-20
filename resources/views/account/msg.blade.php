@extends('layouts.master')
@section('content')
<style>

    .chars-list {
        display: none
    }
</style>
<div class="main-content">
    <!-- Change Password Section -->
    <div class="account-section">
        <div class="account-section-title">
            <i class="fas fa-key"></i> Thông báo
        </div>

        <form id="password-form" action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="msg">Thông báo:</label>
                <input type="" id="msg" name="msg" class="form-control" required="">
            </div>

            <div class="form-group">
                <label for="otp">Kiểu thông báo:</label>
                <select name="type" class="form-control" style="background: black">
                    <option value="9">Quảng bá</option>
                    <option value="1">Thế giới</option>
                </select>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary">Thông báo</button>
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script>
    $("#otp").click(function() {
            $.LoadingOverlay("show", {
                image: "",
                fontawesome : "fa-solid fa-envelope-open-text"
            })
            $("#optsuccess").css("display", "none")
            var base_url = '/otp'
            event.preventDefault();

            $.ajax({
                url: base_url,
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "POST"
            }).done(function() {
                $.LoadingOverlay("hide")
                $("#optsuccess").css("display", "block")
            }).fail(function(data) {
                //$.LoadingOverlay("hide")
                alert("Có lỗi xảy ra, vui lòng thử lại sau!");
            });;
        })
</script>
@endsection