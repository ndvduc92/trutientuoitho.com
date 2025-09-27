<?php
namespace App\Http\Controllers;

use App\Models\CharItem;
use App\Models\Shake;
use App\Models\User;
use App\Models\Wheel;
use App\Models\WheelItem;
use App\Models\WheelUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;

class ShakeController extends Controller
{

    public function shake()
    {
        $wheel     = Wheel::with("items")->find(1);
        $daily     = Wheel::with("items")->find(1);
        $vip       = Wheel::with("items")->find(2);
        $coin      = Wheel::with("items")->find(3);
        $items     = WheelUser::with("wheel_item", "wheel_item.item")->whereDate("created_at", Carbon::today())->where("user_id", current_user()->id)->latest()->get();
        $plus      = Shake::where("user_id", current_user()->id)->sum("count");
        $inventory = CharItem::where("char_id", current_user()->main_id)->with("item")->get();
        return view("tambao.index", compact("wheel", "items", "plus", "daily", "vip", "coin", "inventory"));
    }

    public function getWheelItem()
    {
        return Wheel::where("type", "daily")->first()->items;
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

        $item = WheelItem::find($id);

        $exist = CharItem::where("itemid", $item->itemid)
            ->where("char_id", current_user()->main_id)
            ->first();
        if (! $exist) {
            $newItem           = new CharItem();
            $newItem->user_id  = current_user()->id;
            $newItem->char_id  = current_user()->main_id;
            $newItem->itemid   = $item->itemid;
            $newItem->quantity = $item->quantity;
            $newItem->save();
        } else {
            $exist->quantity += $item->quantity;
            $exist->save();
        }
        if ($item->broadcast == 1) {
            $player = \Auth::user()->char->name;
            $name   = "Rương May Mắn";
            $msg    = "[{$player}] đã nhận được [{$content}] từ " . $name;
            sendMsg($msg);
        }
    }

    public function postWheelItem(Request $request)
    {
        $wheel     = Wheel::where("type", "daily")->first();
        $freeTimes = $wheel->usedTimes("free");
        $plusTimes = $wheel->usedTimes("plus");

        $plus = Shake::where("user_id", current_user()->id)->sum("count");

        $totalTimes = $wheel->num_of_times + $plus;
        $totalUsed  = $freeTimes + $plusTimes;
        if ($totalUsed >= $totalTimes) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Số lần mở hôm nay đã hết!',
            ]);
        }

        $type = "free";
        if ($freeTimes < $wheel->num_of_times) {
            $type = "free";
        } else {
            $type = "plus";
        }

        $label      = [];
        $rate       = [];
        $reward     = [];
        $wheel_item = [];
        $items      = $this->getWheelItem();
        foreach ($items as $item) {
            $wheel_item[] = $item->id;
            $label[]      = $item->item->name . " x" . $item->quantity;
            $rate[]       = $item->ratio;
            $reward[]     = $item->item->name;
        }
        $out = $this->getRandomWeightedElement($rate);

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
        if ($user->balance < request()->count * 10000) {
            return back()->with("error", "Số dư không đủ để mua lượt!");
        }
        $shake          = new Shake;
        $shake->user_id = current_user()->id;
        $shake->count   = request()->count;
        $shake->date    = Carbon::now();
        $shake->save();

        $user->balance = intval($user->balance) - request()->count * 10000;
        $user->save();
        return back()->with("success", "Mua thêm lượt thành công!");
    }
}
