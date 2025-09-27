<?php
namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\AchievementShop;
use App\Models\AchievementUser;
use App\Models\QuestUser;
use App\Models\Kill;
use App\Models\Logging;
use App\Models\Transaction;
use Auth;
use DB;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get()
    {
        $type = request()->type ?? "online";
        $data = AchievementUser::where("user_id", current_user()->id)->where("type", $type)->get()->pluck("value")->toArray();
        $pk   = Kill::where("kill", Auth::user()->main_id)->count();
        $be_killed   = Kill::where("be_killed", Auth::user()->main_id)->count();
        $boss = Logging::where("type", "boss")->where("char_id", current_user()->main_id)->count();
        $quest = QuestUser::where("user_id", current_user()->id)->count();
        return view("achievements.index", compact("data", "pk", "boss", "quest", "be_killed"));
    }

    public function shop()
    {
        $shops = AchievementShop::where("status", "active")->orderBy("id", "desc")->get();
        return view("achievements.shop", compact("shops"));
    }

    public function postShop(Request $request)
    {
        $user = Auth::user();
        if ($user->main_id == "") {
            return redirect()->back()->with('error', 'Chưa chọn nhân vật để mua vật phẩm.');
        }

        if ($request->quantity < 1) {
            return redirect()->back()->with('error', 'Số lượng không thể nhỏ hơn 1.');
        }

        $shop = AchievementShop::findOrFail($request->shop_id);
        if ($request->quantity > $shop->stack) {
            return redirect()->back()->with('error', 'Số lượng không thể lớn hơn số lượng xếp chồng của vật phẩm.');
        }

        $xu_event      = $user->xu_event;
        $xu_event_used = $user->xu_event_used;
        $balance         = $xu_event - $xu_event_used;

        $cash    = $request->quantity * $shop->price;
        if ($balance < $cash) {
            return redirect()->back()->with('error', 'Số xu web trong tài khoản không đủ (cần ' . $cash . ' xu, thiếu ' . $cash - $balance . ' xu)');
        }
        try {
            DB::beginTransaction();
            $this->callGameApi("post", "/api/mail.php", [
                "receiver" => $user->main_id,
                "itemid"   => $shop->itemid,
                "count"    => $request->quantity,
                "proctype" => 19,
                "msg"      => "[WebShop][".$shop->item->name."] x".$request->quantity,
            ]);
            $user->xu_event_used = intval($user->xu_event_used) + $cash;
            $user->save();

            $transaction                = new Transaction;
            $transaction->user_id       = $user->id;
            $transaction->shop_quantity = $request->quantity;
            $transaction->shop_id       = $request->shop_id;
            $transaction->type          = "shop-coin";
            $transaction->char_id       = $user->main_id;
            $transaction->save();
            DB::commit();
            //$msg = Auth::user()->char->name . ' đã mua ' . $request->quantity . ' cái [' . $shop->item->name . '] từ Linh Bảo Các ';
            //sendMsg($msg);
            return back()->with('success', 'Chúc mừng bạn đã mua thành công ' . $request->quantity . ' cái ' . $shop->item->name . ' với giá ' . $cash . ' (xu)');

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }

    private function check($type, $value)
    {
        $finished = false;
        switch ($type) {
            case 'online':
                $time_used = Auth::user()->char->time_used;
                if (intval($time_used) >= intval($value) * 3600) {
                    $finished = true;
                }
                break;
            case 'pk':
                if (Kill::where("kill", Auth::user()->main_id)->count() >= $value) {
                    $finished = true;
                }
                break;
            case 'be_killed':
                if (Kill::where("be_killed", Auth::user()->main_id)->count() >= $value) {
                    $finished = true;
                }
                break;
            case 'quest':
                if (QuestUser::where("user_id", current_user()->id)->count() >= $value) {
                    $finished = true;
                }
                break;
            case 'boss':
                if (Logging::where("type", "boss")->where("char_id", current_user()->main_id)->count() >= $value) {
                    $finished = true;
                }
                # code...
                break;
            default:
                # code...
                break;
        }
        return $finished;
    }

    public function post($type, $id)
    {
        try {
            $types = [
                //"pk"     => "Giết địch",
                //"boss"   => "Diệt Voss",
                "quest"    => "Nhiệm Vụ",
                "online" => "Online",
                //"be_killed" => "Bị Giết"
            ];

            if (! $this->check($type, $id)) {
                return back()->with("error", "Chưa đủ điều kiện hoàn thành!");
            }

            $data          = Achievement::TYPES[$type];
            $result        = collect($data)->firstWhere('goal', $id);
            $item          = new AchievementUser;
            $item->user_id = current_user()->id;
            $item->char_id = current_user()->main_id;
            $item->value   = $id;
            $item->type    = $type;
            $item->date    = now();
            $item->save();
            $user           = Auth::user();
            $user->xu_event = $user->xu_event + $result["coin"];
            $user->save();
            $xx = $types[$type];
            //$msg = Auth::user()->char->name . ' đã nhận ' . $result["coin"] . ' xu web từ hệ thống thành tựu ['.$xx.": ".$id."]";
            //sendMsg($msg);
            //return back()->with("success", "Tính năng đang được cập nhật...!");
            return back()->with("success", "Đã nhận phần thưởng thành công!");
        } catch (\Throwable $th) {
            return back()->with("error", "Đã nhận phần thưởng này rồi!");
        }

    }
}
