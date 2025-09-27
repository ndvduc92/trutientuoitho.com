<?php
namespace App\Http\Controllers;

use App\Models\Shake;
use App\Models\User;
use App\Models\Wheel;
use App\Models\WheelItem;
use App\Models\WheelUser;
use hrace009\PerfectWorldAPI\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;

class ShakeController extends Controller
{

    public function shake()
    {
        $wheel = Wheel::with("items")->find(1);
        $daily = Wheel::with("items")->find(1);
        $vip   = Wheel::with("items")->find(2);
        $coin  = Wheel::with("items")->find(3);
        $items = WheelUser::with("wheel_item", "wheel_item.item")->whereDate("created_at", Carbon::today())->where("user_id", current_user()->id)->latest()->get();
        $plus  = Shake::where("user_id", current_user()->id)->sum("count");
        return view("shake.index", compact("wheel", "items", "plus", "daily", "vip", "coin"));
    }

    public function getWheelItem($type)
    {
        $maps = [
            "free" => "daily",
            "vip"  => "vip",
            "plus" => "coin",
        ];
        return Wheel::where("type", $maps[$type])->first()->items;
    }

    public function getRandomWeightedElement($weightedValues)
    {
        $rand = mt_Rand(1, (int) array_sum($weightedValues));
        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }
    }

    public function store($content, $id, $type)
    {
        $history                = new WheelUser();
        $history->msg           = $content;
        $history->user_id       = \Auth::user()->id;
        $history->wheel_item_id = $id;
        $history->type          = $type;
        $history->save();

        // $wheel = Wheel::where("type", "daily")->first();
        // if ($wheel->coin_amount != 0) {
        //     $user          = Auth::user();
        //     $user->balance = $user->balance - $wheel->coin_amount;
        //     $user->save();
        // }

        $item = WheelItem::find($id);
        $this->callGameApi("post", "/api/mail.php", [
            "receiver" => Auth::user()->main_id,
            "itemid"   => $item->itemid,
            "count"    => $item->quantity,
            "proctype" => $item->bind,
            "msg"      => "[Cây Tài Lộc][" . $item->item->name . "] x" . $item->quantity,
        ]);
        $api    = new API();
        $player = \Auth::user()->char->name;
        $name   = "Cây Tài Lộc miễn phí";
        if ($type == "vip") {
            $name = "Cây Tài Lộc VIP";
        } elseif ($type == "free") {
            $name = "Cây Tài Lộc miễn phí";
        } else {
            $name = "Cây Tài Lộc Xu";
        }
        $msg = "Chúc mừng [{$player}] đã nhận được [{$content}] từ " . $name;
        sendMsg($msg);
    }

    public function postWheelItem(Request $request)
    {
        $wheel     = Wheel::where("type", "daily")->first();
        $freeTimes = $wheel->usedTimes("free");
        $vipTimes  = $wheel->usedTimes("vip");
        $plusTimes = $wheel->usedTimes("plus");

        $plus = Shake::where("user_id", current_user()->id)->sum("count");

        if (current_user()->viplevel == 0) {
            $totalTimes = $wheel->num_of_times + $plus;
            $totalUsed  = $freeTimes + $plusTimes;
            if ($totalUsed >= $totalTimes) {
                return response()->json([
                    'status' => 'error',
                    'msg'    => 'Số lần quay hôm nay đã hết!',
                ]);
            }
        } else {
            $totalTimes = $wheel->num_of_times + $plus + Auth::user()->viplevel;
            $totalUsed  = $freeTimes + $plusTimes + $vipTimes;
            if ($totalUsed >= $totalTimes) {
                return response()->json([
                    'status' => 'error',
                    'msg'    => 'Số lần quay hôm nay đã hết!',
                ]);
            }
        }

        $type = "free";
        if ($freeTimes < $wheel->num_of_times) {
            $type = "free";
        } else {
            if (current_user()->viplevel == 0) {
                $type = "plus";
            } else {

                if ($vipTimes < Auth::user()->viplevel) {
                    $type = "vip";
                } else {
                    $type = "plus";
                }
            }
        }

        $label      = [];
        $rate       = [];
        $reward     = [];
        $wheel_item = [];
        $items      = $this->getWheelItem($type);
        foreach ($items as $item) {
            $wheel_item[] = $item->id;
            $label[]      = $item->item->name . " x" . $item->quantity;
            $rate[]       = $item->ratio;
            $reward[]     = $item->item->name;
        }
        $out = $this->getRandomWeightedElement($rate, $type);

        $this->store($label[$out], $wheel_item[$out], $type);

        return response()->json([
            'status' => 'success',
            'item'   => WheelItem::find($wheel_item[$out]),
            'msg'    => $label[$out],
            'used'   => $wheel->usedTimes($type),
            "type"   => $type,
        ]);
    }

    public function addLuot()
    {

        $user = Auth::user();
        if ($user->balance < request()->count * 5000) {
            return back()->with("error", "Số dư không đủ để mua lượt!");
        }
        $shake          = new Shake;
        $shake->user_id = current_user()->id;
        $shake->count   = request()->count;
        $shake->date    = Carbon::now();
        $shake->save();

        $user->balance = intval($user->balance) - request()->count * 5000;
        $user->save();
        return back()->with("success", "Mua thêm lượt rung cây thành công!");
    }
}
