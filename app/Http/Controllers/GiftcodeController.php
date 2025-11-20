<?php
namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Giftcode;
use App\Models\GiftcodeOnlyUser;
use App\Models\GiftcodeUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class GiftcodeController extends Controller
{

    public function getGiftcode()
    {
        $category = request()->get("category", "all");
        $user     = Auth::user();
        $ids      = [];
        if ($category == "all") {
            $id1  = Giftcode::where("type", "all")->whereDate('expired', '>=', Carbon::now())->pluck("id")->toArray();
            $id2  = GiftcodeOnlyUser::where("user_id", $user->id)->pluck("giftcode_id")->toArray();
            $data = array_merge($id1, $id2);
        } else {
            $data = Giftcode::where("type", "vip")->where("viplevel", "<=", $user->viplevel)->pluck("id")->toArray();
        }
        $giftcodes = Giftcode::with("items")->whereIn("id", $data)->get();
        return view("giftcodes", ["giftcodes" => $giftcodes]);
    }

    public function useGiftcode(Request $request, $id)
    {
        $user = Auth::user();
        if (! $user->main_id) {
            return back()->with("error", "Vui lòng vào game tạo nhân vật!!");
        }
        $userGiftcode = GiftcodeUser::where(["user_id" => $user->id, "giftcode_id" => $id])->first();
        if ($userGiftcode) {
            return redirect()->back()->with('error', 'Bạn đã dùng giftcode này!');
        }
        try {
            DB::beginTransaction();
            $code             = Giftcode::find($id);
            if ($code->type == "vip" && $user->viplevel < $code->viplevel) {
                return back()->with("error", "Bạn không đủ cấp độ VIP để sử dụng giftcode này!");
            }
            if ($code->type == "account" && !GiftcodeOnlyUser::where("giftcode_id", $code->id)->where("user_id", $user->id)->first()) {
                return back()->with("error", "Bạn định làm gì? Hack à!");
            }
            $use              = new GiftcodeUser;
            $use->user_id     = $user->id;
            $use->giftcode_id = $id;
            $use->char_id     = $user->main_id;
            if ($code->xu > 0) {
                $user          = Auth::user();
                $user->balance = $user->balance + $code->xu;
                $user->save();
            }
            $use->save();
            $code->count = $code->count + 1;

            $code->save();

            foreach ($code->items as $item) {
                $this->callGameApi("post", "/api/mail.php", [
                    "receiver" => $user->main_id,
                    "itemid"   => $item->itemid,
                    "count"    => $item->quantity,
                    "proctype" => $item->bind,
                    "msg"      => "Giftcode " . $code->giftcode,
                ]);
            }

            DB::commit();
            if ($code->show == "yes") {
                $message = "Chúc mừng " . $user->char->name . " đã nhận giftcode " . $code->giftcode;
                #sendMsg($message);
            }
            return back()->with("success", "Sử dụng giftcode thành công, vui lòng check tín sứ!");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}
