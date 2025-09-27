<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Pack;
use Auth;
use DB;
use hrace009\PerfectWorldAPI\API;

class PackController extends Controller
{
    public function get()
    {
        $packs = Pack::where("status", "active")->get();
        return view("packs", ["packs" => $packs]);
    }


    public function buy($id)
    {
        $shop = Pack::findOrFail($id);
        if (! isOnline()) {
            return redirect()->back()->with('error', 'Hãy quay lại khi server hoạt động.');
        }
        if ($shop->status == "inactive") {
            return back();
        }
        $user = Auth::user();
        if ($user->main_id == "") {
            return redirect()->back()->with('error', 'Chưa chọn nhân vật để mua vật phẩm.');
        }

        $balance = $user->balance;
        $cash    = $shop->price;
        if ($balance < $cash) {
            return redirect()->back()->with('error', 'Số xu trong tài khoản không đủ (cần ' . $cash . ' xu, thiếu ' . $cash - $balance . ' xu), vui lòng nạp thêm.');
        }
        try {
            DB::beginTransaction();
            foreach ($shop->items as $item) {
                $this->callGameApi("post", "/api/mail.php", [
                    "receiver" => $user->main_id,
                    "itemid"   => $item->itemid,
                    "count"    => $item->quantity,
                    "proctype" => $item->bind,
                    "msg"      => "Vật phẩm mua từ Gói ưu đãi",
                ]);
            }
            $user->balance = $balance - $cash;
            $user->save();

            $transaction                = new Transaction;
            $transaction->user_id       = $user->id;
            $transaction->shop_quantity = 1;
            $transaction->shop_id       = $shop->id;
            $transaction->type          = "pack";
            $transaction->char_id       = $user->main_id;
            $transaction->save();

            $api     = new API();
            $message = "Chúc mừng " . $user->char->name . " đã mua được " . $shop->name . " từ Gói Ưu đãi với giá " . number_format($cash) . ' (xu)';
            sendMsg($message);
            DB::commit();
            return back()->with('success', 'Chúc mừng bạn đã mua thành công gói ' . $shop->name . ' với giá ' . $cash . ' (xu)');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}