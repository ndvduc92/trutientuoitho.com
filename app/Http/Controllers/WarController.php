<?php
namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Guild;
use App\Models\PkBoss;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Faction;
use App\Models\Vip;
use Auth;
use Carbon\Carbon;
use DB;
use hrace009\PerfectWorldAPI\API;
use Illuminate\Http\Request;

class WarController extends Controller
{

    public function index()
    {
        $date = PkBoss::latest()->first()->date;
        $date = Carbon::parse($date)->format("Y-m-d");
        $type = request()->type ?? "date";
        $data = [];
        if ($type == "date") {
            $data = $this->wars($date);
        } else {
            $data = Char::whereNot("war_kill", 0)->whereNot("war_be_killed", 0)->orderByRaw('war_kill - war_be_killed DESC')->get();

        }
        return view("war", [
            "chars" => $data,
            "date"  => $date,
        ]);
    }

    public function live()
    {
        $data = $this->wars("2025/07/20");
        $galaxy     = 6;
        $tamquoc    = 9;
        $galaxyMem  = Faction::find($galaxy)->getAllMember();
        $tamquocMem = Faction::find($tamquoc)->getAllMember();

        $grouped = [
            'galaxy'  => [],
            'tamquoc' => [],
        ];
        foreach ($data as $char) {
            $charId = (int) $char['char_id'];

            if (in_array($charId, $galaxyMem)) {
                $grouped['galaxy'][] = $char;
            }

            if (in_array($charId, $tamquocMem)) {
                $grouped['tamquoc'][] = $char;
            }
        }
        return view("war-live", [
            "data" => $grouped,
            "date" => Carbon::now()->format("Y/m/d"),
        ]);
    }

    private function wars($date = null)
    {

        $kill      = PkBoss::groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
        $be_killed = PkBoss::groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();

        if ($date) {
            $kill      = PkBoss::whereDate('date', '=', Carbon::parse($date)->format("Y/m/d"))->groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
            $be_killed = PkBoss::whereDate('date', '=', Carbon::parse($date)->format("Y/m/d"))->groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();
        }

        $result1 = array_map(function ($val) {
            return $val['kill'];
        }, (array) $kill->toArray());

        $result2 = array_map(function ($val) {
            return $val['be_killed'];
        }, (array) $be_killed->toArray());

        $chars = array_values(array_unique(array_merge($result1 + $result2)));

        $res = [];

        $names = Char::with("user")->whereIn("char_id", $chars)->get();

        foreach ($chars as $char) {
            $kills      = collect($kill)->firstWhere('kill', $char);
            $be_killeds = collect($be_killed)->firstWhere('be_killed', $char);
            $char       = [
                "char_id"       => $char,
                "class_icon"    => collect($names)->firstWhere('char_id', $char)["class_icon"],
                "class_name"    => collect($names)->firstWhere('char_id', $char)["class_name"],
                "user_id"       => collect($names)->firstWhere('char_id', $char)["user"]["id"],
                "name"          => collect($names)->firstWhere('char_id', $char)["name"],
                "war_kill"      => $kills ? $kills["total"] : 0,
                "war_be_killed" => $be_killeds ? $be_killeds["total"] : 0,
            ];
            $res[] = $char;
        }

        $sorted = collect($res)->sortBy([
            ['war_kill', 'desc'],
            ['war_be_killed', 'asc'],
        ]);

        $res = $sorted->values()->all();

        return $res;
    }

    public function shopHistory()
    {
        $shops = Transaction::where("type", "shop")->latest()->get();
        return view('histories', ["shops" => $shops]);
    }

    public function getWarKnb()
    {
        return view("war-knb");
    }

    public function postWarKnb()
    {
        if (! isOnline()) {
            return back()->with("error", "Server chưa hoạt động. Vui lòng quay lại sau.");
        }
        $ratio = 2;
        $user  = Auth::user();

        $war_point      = $user->war_point;
        $war_point_used = $user->war_point_used;
        $remain         = $war_point - $war_point_used;
        $xu             = request()->cash;
        if ($xu < 50 || $remain < $xu) {
            return back()->with("error", "Số điểm quy đổi phải lớn hơn 50 và nhỏ hơn số điểm chiến tích hiện có!");
        }

        $now = Carbon::now();

        $lastRecord = Vip::where("user_id", Auth::user()->id)->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return back()->with("error", "Thao tác quá nhanh, quay lại sau vài phút nữa nhé!!!");
            }

        }

        $lastRecord = Transaction::where("user_id", Auth::user()->id)->where("type", "knb")->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return back()->with("error", "Thao tác quá nhanh, quay lại sau 2 phút nữa nhé!!!");
            }

        }

        $lastRecord = Transaction::where("user_id", Auth::user()->id)->where("type", "war_knb")->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return back()->with("error", "Thao tác quá nhanh, quay lại sau 2 phút nữa nhé!!!");
            }

        }
        try {
            DB::beginTransaction();
            $this->callGameApi("POST", "/api/knb.php", [
                "userid" => $user->userid,
                "cash"   => intval($xu * 100) * $ratio,
            ]);
            $user->war_point_used = intval($user->war_point_used) + $xu;
            $user->save();

            $transaction             = new Transaction;
            $transaction->user_id    = $user->id;
            $transaction->knb_amount = $xu * 2;
            $transaction->type       = "war_knb";
            $transaction->save();
            return back()->with("success", "Đã chuyển " . intval($xu) * $ratio . " KNB vào game thành công!");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }

    public function warHistory()
    {

        $knbs = Transaction::with("guild", "guild.item")->where("type", "war")->latest()->paginate(50);
        return view("war-history", ["knbs" => $knbs]);
    }

    public function getShop()
    {
        $shops = Guild::where("status", "active")->get();
        return view("wars.shop", ["shops" => $shops]);
    }

    public function postShop(Request $request)
    {
        if (! isOnline()) {
            return redirect()->back()->with('error', 'Hãy quay lại khi server hoạt động.');
        }
        $user = Auth::user();
        if ($user->main_id == "") {
            return redirect()->back()->with('error', 'Chưa chọn nhân vật để mua vật phẩm.');
        }

        if ($request->quantity < 1) {
            return redirect()->back()->with('error', 'Số lượng không thể nhỏ hơn 1.');
        }

        $shop = Guild::find($request->shop_id);
        if ($request->quantity > $shop->stack) {
            return redirect()->back()->with('error', 'Số lượng không thể lớn hơn số lượng xếp chồng của vật phẩm.');
        }
        $war_point      = $user->war_point;
        $war_point_used = $user->war_point_used;
        $remain         = $war_point - $war_point_used;
        $cash           = $request->quantity * $shop->price;
        if ($remain < $cash) {
            return redirect()->back()->with('error', 'Số xu war không đủ.');
        }
        try {
            DB::beginTransaction();
            $this->callGameApi("post", "/api/mail.php", [
                "receiver" => $user->main_id,
                "itemid"   => $shop->itemid,
                "count"    => $request->quantity,
                "msg"      => "[Shop Bang Chiến]",
                "proctype" => $shop->bind,
            ]);
            $user->war_point_used = $war_point_used + $cash;
            $user->save();

            $transaction                = new Transaction;
            $transaction->user_id       = $user->id;
            $transaction->shop_quantity = $request->quantity;
            $transaction->shop_id       = $request->shop_id;
            $transaction->type          = "war";
            $transaction->char_id       = $user->main_id;
            $transaction->save();
            //if ($shop->broadcast == 1) {
            $api  = new API;
            $name = Auth::user()->char->name;
            $item = $shop->item->name;
            $num = $request->quantity;
            $msg = "[{$name}]: đã mua [{$item}] x{$num} từ Shop Bang Chiến.";
            sendMsg($msg);
            DB::commit();
            return back()->with('success', 'Chúc mừng bạn đã mua thành công ' . $request->quantity . ' cái ' . $shop->item->name . ' với ' . $cash . ' xu war');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}
