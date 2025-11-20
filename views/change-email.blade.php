@extends('layouts.master')
@section('content')
<style>
  .chars-list {
    display: none
  }
</style>
<div class="main-content">

  <div class="account-section">
    <div class="account-section-title">
      Đổi email
    </div>

    <form id="contact-form" action="" method="POST">
      @csrf
      <div class="form-group">
        <input type="email" id="old" name="old" class="form-control" required="" placeholder="Email hiện tại">
      </div>
      <div class="form-group">
        <input type="email" id="new" name="new" class="form-control" required="" placeholder="Email mới">
      </div>
      <div class="form-group">
        <label for="otp">OTP <span>(<strong role="button" id="otp" style="cursor:pointer; color:red">Nhấn
          vào ĐÂY</strong> lấy OTP về email)</span>:</label>
        <input type="" id="otp" name="otp" class="form-control" required="">
        <div class="col-span-6 sm:col-span-4" id="optsuccess" style="display: none">
          <label style="color:red" class="block font-medium text-sm text-red-700 dark:text-light">
              *Vui lòng kiểm tra email để lấy mã OTP.
          </label>

      </div>
      </div>

      <div class="">
        <button type="submit" class="btn btn-primary" onclick="updateContactInfo()">ĐỔI EMAIL</button>
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
      var base_url = '/doi-email/otp'
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
          $.LoadingOverlay("hide")
          alert("Có lỗi xảy ra, vui lòng thử lại sau!");
      });;
  })
</script>
@endsection