<div id="them-luot" class="jade-modal2">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Mua thêm lượt</h3>
            <span class="close-btn" onclick="document.getElementById('them-luot').classList.remove('show');">×</span>
        </div>
        <form class="modal-body" action="/ruong-may-man/mua-luot" method="POST">
            @csrf
            <div class="exchange-rate">
                <span class="rate-text">Giá tiền 1 lượt: <span class="rate-value">10000 xu</span></span>
            </div>
            <br>
            <div class="input-group">
                <div class="input-with-suffix">
                    <input placeholder="Số lượt mua thêm" name="count" type="number" id="ExchGAmount" class="form-control" maxlength="100" min="1">
                </div>
            </div>

            <div class="modal-actions">
                <button class="jade-btn primary" type="submit">Mua lượt</button>
                <span class="jade-btn secondary"
                    onclick="document.getElementById('them-luot').classList.remove('show');">Cancel</span>
            </div>
        </form>
    </div>
</div>


<div id="tui-do" class="jade-modal2">
    <div class="modal-content" style="width: 50%">
        <div class="modal-header">
            <h3>Túi đồ</h3>
            <span class="close-btn"
                onclick="document.getElementById('tui-do').classList.remove('show');">×</span>
        </div>
        <div class="modal-body" style="text-align: left">
            <div style="margin-top:0px">
                <p>Vui lòng <a href="">nhấn vào đây</a> để refresh lại trình duyệt nếu vật phẩm chưa vào túi</p>
        <div class="bag-grid">
            @foreach ($inventory as $item)
            <div stack="{{$item->stack}}" itemname="{{$item->item->name}}" itemid="{{$item->id}}" class="item bag-slot vip-glow quality-legendary"
                title="{{$item->item->name}}" style="cursor: pointer;">
                <img src="{{$item->image}}" />
                <div class="bag-count">{{$item->quantity}}</div>
            </div>
            @endforeach
        </div>
        <form action="/inventory" method="POST" hidden id="purchase-form">
            @csrf
            <div class="quantity-selector">
                <label class="quantity-label" for="quantity"><span id="quantity"></span></label>
                <input type="hidden" id="shop_id" name="shop_id" value="">
            </div>

            <!-- Purchase Button -->
            <br>
            <button class="btn-primary btn" type="submit" style="">
                Chuyển vào game
            </button>
        </form>

    </div>
        </div>
    </div>
</div>
<div id="exchange-modal-giai-thuong" class="jade-modal2">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Danh Sách Giải Thưởng</h3>
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
            <div id="daily">
                @foreach ($daily->items as $item)
                <p>{{$loop->index + 1}}) {{$item->name}} x{{$item->quantity}} (Tỉ lệ: {{$item->ratio}}%)</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="exchange-modal-lich-su" class="jade-modal2">
    <div class="modal-content" style="width: 60%">
        <div class="modal-header">
            <h3>Lịch sử nhận thưởng</h3>
            <span class="close-btn"
                onclick="document.getElementById('exchange-modal-lich-su').classList.remove('show');">×</span>
        </div>
        <div class="modal-body" style="text-align: left; max-height:500px; overflow: auto">
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

<script>
    $(".item").on("click", function() {
    $("#purchase-form").show();
    var itemId = $(this).attr("itemid");
    var itemname = $(this).attr("itemname");
    var quantity = $(this).find(".bag-count").text();
    $("#shop_id").val(itemId);
    $("#quantity").text(`${itemname} x${quantity}`);
});
</script>


<style>
    .jade-modal2 {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .jade-modal2.show {
        display: block;
        animation: fadeIn 0.3s;
    }

    .jade-modal2 .modal-content {
        background: #fff;
        margin: 10% auto;
        width: 420px;
        max-width: 90%;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        animation: slideDown 0.3s;
        position: relative;
        overflow: hidden;
    }

    .jade-modal2 .modal-header {
        background: #1baac2;
        color: #fff;
        padding: 14px 20px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .jade-modal2 .modal-header h3 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: bold;
        color: #fff !important;
    }

    .jade-modal2 .close-btn {
        color: #fff;
        font-size: 22px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .jade-modal2 .close-btn:hover {
        color: #e0f2fe;
    }

    .jade-modal2 .modal-body {
        padding: 20px;
        color: #374151;
    }

    .jade-modal2 .modal-description {
        text-align: center;
        margin-bottom: 15px;
        font-size: 1rem;
        color: #4b5563;
    }

    .jade-modal2 .modal-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 20px;
    }

    .jade-modal2 .jade-btn {
        padding: 10px 22px;
        font-size: 0.95rem;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s;
        border: none;
        font-family: inherit;
    }

    .jade-modal2 .jade-btn.primary {
        background: #3b82f6;
        color: #fff;
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.4);
    }

    .jade-modal2 .jade-btn.primary:hover {
        background: #2563eb;
    }

    .jade-modal2 .jade-btn.secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .jade-modal2 .jade-btn.secondary:hover {
        background: #e5e7eb;
    }
</style>

<style>

    .bag-grid {
        display: grid;
        grid-template-columns: repeat(6, 64px);
        gap: 10px;
        padding: 16px;
        border-radius: 8px;
        width: fit-content;
    }

    .bag-slot {
        position: relative;
        width: 50px;
        height: 50px;
        border: 2px solid #555;
        border-radius: 6px;
        overflow: hidden;
        transition: border-color 0.2s;
    }

    .bag-slot img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .bag-count {
        position: absolute;
        bottom: 2px;
        right: 3px;
        font-size: 12px;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 0 5px;
        border-radius: 4px;
    }

    .quality-common {
        border-color: #777;
    }

    .quality-rare {
        border-color: #1e90ff;
    }

    .quality-epic {
        border-color: #a64efc;
    }

    .quality-legendary {
        border-color: #ff9900;
    }

    .bag-slot:hover {
        border-color: gold;
    }
</style>