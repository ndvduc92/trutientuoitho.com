var base_url_path = typeof BASE_URL_PATH != "undefined" ? BASE_URL_PATH : "";
console.log(base_url_path);
// if(base_url_path === '') {
//     var pathname = window.location.pathname;
//     pathname = pathname.split("/");
//     var strgame = pathname[1];
//     base_url_path = BASE_URL + '/' + strgame;
// }

function isLogin() {
  //   jQuery
  //     .ajax({
  //       method: "POST",
  //       url: base_url_path + "/is-login.html",
  //       dataType: "json",
  //     })
  //     .done(function (msg) {
  //       if (msg.isLogin == true) {
  //         jQuery("#login-box").html(msg.result);
  //         jQuery("#btn_dk_tk").removeClass("DangKy").addClass("TaiKhoan");
  //         jQuery("#btn_dk_tk").attr("title", "Tài khoản");
  //         is_login = true;
  //       }
  //     });
}
