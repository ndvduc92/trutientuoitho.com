<div id="them-luot" class="jade-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Mua thêm lượt rung cây</h3>
            <span class="close-btn" onclick="document.getElementById('them-luot').classList.remove('show');">×</span>
        </div>
        <form class="modal-body" action="/rung-cay/mua-luot" method="POST">
            @csrf
            <p class="modal-description">Tối đa mỗi ngày được mua thêm 100 lượt.</p>
            <div class="exchange-rate">
                <span class="rate-text">Giá tiền 1 lượt: <span class="rate-value">5000 xu</span></span>
            </div>

            <div class="input-group">
                <label for="ExchGAmount">Số lượt mua thêm:</label>
                <div class="input-with-suffix">
                    <input name="count" type="number" id="ExchGAmount" class="jade-input" maxlength="100" min="1">
                    <span class="input-suffix">lượt</span>
                </div>
            </div>

            <div class="modal-actions">
                <button class="jade-btn primary" type="submit">Mua lượt</button>
                <button class="jade-btn secondary"
                    onclick="document.getElementById('them-luot').classList.remove('show');">Cancel</button>
            </div>
        </form>
    </div>
</div>


<div id="exchange-modal-the-le" class="jade-modal">
    <div class="modal-content" style="width: 50%">
        <div class="modal-header">
            <h3>Thể lệ</h3>
            <span class="close-btn"
                onclick="document.getElementById('exchange-modal-the-le').classList.remove('show');">×</span>
        </div>
        <div class="modal-body" style="text-align: left">
            <p style="color: red"><i class="fas fa-leaf text-success"></i> <strong>THỂ LỆ</strong></p>

            <p>Mỗi tài khoản nhận được 3 lượt rung cây miễn phí mỗi ngày.</p>

            <p>Mỗi tài khoản được miễn phí thêm x lần lượt rung cây mỗi ngày (x là số vip hiện tại).</p>

            <p>Mỗi tài khoản có thể mua thêm không giới hạn số lượt rung cây.</p>

            <p>Lượt rung cây sử dụng lần lượt theo Miễn phí -> VIP -> Mua thêm.</p>

            <p><span style="color: red">Chú ý: </span>Số lượt rung cây mỗi ngày sẽ reset, xin hãy sử dụng hết quyền lợi
                rung cây tối đa mỗi ngày. Số lượt mua thêm sẽ cộng dồn, không tính theo ngày.</p>

            {{-- <p style="color: red"><i class="fas fa-trophy text-danger"></i> <strong>CÁCH TÍNH ĐIỂM XẾP
                    HẠNG</strong></p>

            <p>Hệ thống sẽ ghi nhận ngày có điểm tích lũy cao nhất từ số lần Rung cây mỗi ngày để xếp hạng.</p>

            <p>BXH sẽ cập nhật theo điểm thành tích Rung cây cao nhất mỗi ngày (không cộng dồn điểm qua các ngày).</p>


            <p>Các lượt Rung cây được thưởng từ 3 lần Free mỗi ngày, và các Quả thêm 1 lượt, thêm 2 lượt đều không được
                tính điểm trên
                BXH.</p>

            <p>Rung cây hàng ngày sẽ nhận được một số loại vật phẩm ngẫu nhiên, vật phẩm càng hiếm thì số điểm càng lớn
            </p> --}}
        </div>
    </div>
</div>
<div id="exchange-modal-giai-thuong" class="jade-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Giải thưởng</h3>
            <span class="close-btn"
                onclick="document.getElementById('exchange-modal-giai-thuong').classList.remove('show');">×</span>
        </div>
        <div class="modal-body award" style="text-align: left">
            <style>
                .award .stat-box {
                    min-width: 80px;
                    cursor: pointer;
                }

                .award .stat-box.active {
                    background-color: red;
                }
            </style>
            <div class="shop-stats">
                <div class="stat-box active" name="Miễn phí">
                    <i class="fas fa-coins"></i>
                    <a id="btn_daily" title="Xu nạp">Miễn phí</a>
                </div>
                <div class="stat-box" name="Vip">
                    <i class="fas fa-gem"></i>
                    <a id="btn_vip" title="Xu war">Vip</a>
                </div>
                <div class="stat-box" name="Xu">
                    <i class="fas fa-gem"></i>
                    <a id="btn_coin" title="Xu war">Xu</a>
                </div>
            </div>
            <p style="color: red; text-transform:uppercase"><i class="fas fa-leaf text-success"></i> <strong>CÂY TÀI LỘC <span id="name">MIỄN PHÍ</span></strong></p>
            <div id="daily">
            @foreach ($daily->items as $item)
            <p>- {{$item->name}} x{{$item->quantity}}</p>
            @endforeach
            </div>
            <div id="vip" hidden>
            @foreach ($vip->items as $item)
            <p>- {{$item->name}} x{{$item->quantity}}</p>
            @endforeach
            </div>
            <div id="coin" hidden>
            @foreach ($coin->items as $item)
            <p>- {{$item->name}} x{{$item->quantity}}</p>
            @endforeach
            </div>
        </div>
    </div>
</div>
<div id="exchange-modal-lich-su" class="jade-modal">
    <div class="modal-content" style="width: 60%">
        <div class="modal-header">
            <h3>Lịch sử nhận thưởng</h3>
            <span class="close-btn"
                onclick="document.getElementById('exchange-modal-lich-su').classList.remove('show');">×</span>
        </div>
        <div class="modal-body" style="text-align: left; max-height:500px; overflow: auto">
            <p style="color: red"><i class="fas fa-leaf text-success"></i> <strong>Lịch sử 7 ngày gần nhất</strong></p>
            <table id="killers-table">

                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td><img src="{{$item->wheel_item->picture}}" alt="" /> {{ ($item->wheel_item->name) }} x{{
                            ($item->wheel_item->quantity) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('.shop-stats .stat-box').on('click', function () {
        $('.shop-stats .stat-box').removeClass('active');
        $(this).addClass('active');
        $("#name").text( $(this).attr('name'))
    });
    
    $("#btn_vip").click(function() {
        $("#vip").show();
        $("#daily").hide();
        $("#coin").hide();
    });
    $("#btn_daily").click(function() {
        $("#vip").hide();
        $("#daily").show();
        $("#coin").hide();
    });
    $("#btn_coin").click(function() {
        $("#vip").hide();
        $("#daily").hide();
        $("#coin").show();
    });
</script>