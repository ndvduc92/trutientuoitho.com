var ie = (function () {
  var undef,
    v = 3,
    div = document.createElement("div"),
    all = div.getElementsByTagName("i");

  while (
    ((div.innerHTML = "<!--[if gt IE " + ++v + "]><i></i><![endif]-->"), all[0])
  );

  return v > 4 ? v : undef;
})();
function ChoiNgay() {
  if (ie <= 9) {
    window.location.href = PLAY_GAME_URL;
    return;
  }
  if (is_login) {
    window.location.href = PLAY_GAME_URL;
    return;
  }
  $KulCore.setGame(GAME_SLUG);
  $KulCore.setHideHotGame(true);
  $KulCore.setCallBackLogin("CallBackAfterLogin");
  $KulCore.setCallBackRegister("CallBackAfterRegister");
  $KulCore.popupRegister();
}
function DangKy() {
  // var ie = /MSIE ([0-9]+)/g.exec(window.navigator.userAgent)[1] || undefined;
  if (ie <= 9) {
    window.location.href = PLAY_GAME_URL;
    return;
  }
  if (is_login) {
    window.location.href = PLAY_GAME_URL;
    return;
  }
  $KulCore.setGame(GAME_SLUG);
  $KulCore.setHideHotGame(true);
  $KulCore.setCallBackLogin("CallBackAfterLogin");
  $KulCore.setCallBackRegister("CallBackAfterRegister");
  $KulCore.popupRegister();
}
function DangNhap() {
  $KulCore.setGame(GAME_SLUG);
  $KulCore.setHideHotGame(true);
  $KulCore.setCallBackLogin("CallBackAfterLogin");
  $KulCore.setCallBackRegister("CallBackAfterRegister");
  $KulCore.popupLogin();
}
function CallBackAfterRegister() {
  window.location.href = REGISTER_SUCCESS_URL;
}
function CallBackAfterLogin() {
  window.location.href = PLAY_GAME_URL;
}

function MiniClient() {
  window.open(base_url_path + "/download-miniclient.html", "_blank");
}
