@extends('account.layouts.master')
@section('content')
<h1 class="h3 mb-3">Thông Tin Tài Khoản</h1>

<div class="tab-content">
  <div class="tab-pane fade show active" id="account" role="tabpanel">

    <div class="card">
      <div class="card-body">
        <form>
          <div class="mb-3 row">
            <label class="col-form-label col-sm-2 text-sm-start">Tên Đăng Nhập</label>
            <div class="col-sm-10">
              <input disabled type="email" class="form-control form-control-lg" value="{{Auth::user()->name}}">
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-form-label col-sm-2 text-sm-start">ID Tài Khoản</label>
            <div class="col-sm-10">
              <input disabled type="" class="form-control form-control-lg" value="{{Auth::user()->userid}}">
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-form-label col-sm-2 text-sm-start">Email</label>
            <div class="col-sm-10">
              <input disabled type="" class="form-control form-control-lg" value="{{Auth::user()->email}}">
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-form-label col-sm-2 text-sm-start">Xu Nạp</label>
            <div class="col-sm-10">
              <input disabled class="form-control form-control-lg" value="{{number_format(Auth::user()->balance)}}">
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header">

        <h5 class="card-title mb-0">Đổi Mật Khẩu</h5>
      </div>
      <div class="card-body">
        <form>
          <div class="mb-3">
            <input type="email" class="form-control form-control-lg" id="inputEmail4" placeholder="Mật khẩu cũ">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control form-control-lg" id="inputAddress" placeholder="Mật khẩu mới">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control form-control-lg" id="inputAddress2"
              placeholder="Nhập lại mật khẩu mới">
          </div>
          <div class="mb-3">
            <label class="form-label"> <span style="color:red" role="button" id="otp"><i class="align-middle me-1"
                  data-feather="send"></i>Lấy mã OTP</span></label>
            <input type="text" class="form-control form-control-lg" id="inputAddress2" placeholder="Nhập mã OTP">
          </div>
          <button type="submit" class="btn btn-success">Đổi mật khẩu</button>
        </form>

      </div>
    </div>

    <div class="card">
      <div class="card-header">

        <h5 class="card-title mb-0">Đổi Email</h5>
      </div>
      <div class="card-body">
        <form>
          <div class="mb-3">
            <input value="{{Auth::user()->email2}}" disabled class="form-control form-control-lg" id="inputEmail4"
              placeholder="Email hiện tại">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control form-control-lg" id="inputAddress" placeholder="Nhập email mới">
          </div>
          <div class="mb-3">
            <label class="form-label"> <span style="color:red" role="button" id="otp2"><i class="align-middle me-1"
                  data-feather="send"></i>Lấy mã OTP</span></label>
            <input type="text" class="form-control form-control-lg" id="inputAddress2" placeholder="Nhập mã OTP">
          </div>
          <button type="submit" class="btn btn-success">Đổi email</button>
        </form>

      </div>
    </div>

  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
</script>
<script>
  $("#otp").click(function() {
            $("#optsuccess").css("display", "none")
            var base_url = '/account/otp'
            event.preventDefault();

            $.ajax({
                url: base_url,
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                type: "POST"
            }).done(function() {
  
                $("#optsuccess").css("display", "block")
            }).fail(function(data) {
                //$.LoadingOverlay("hide")
                alert("Có lỗi xảy ra, vui lòng thử lại sau!");
            });;
        })


        $("#otp2").click(function() {
      $("#optsuccess").css("display", "none")
      var base_url = '/account/doi-email/otp'
      event.preventDefault();

      $.ajax({
          url: base_url,
          dataType: 'json',
          data: {
              _token: '{{ csrf_token() }}'
          },
          type: "POST"
      }).done(function() {
          $("#optsuccess").css("display", "block")
      }).fail(function(data) {
          alert("Có lỗi xảy ra, vui lòng thử lại sau!");
      });;
  })
</script>
@endsection