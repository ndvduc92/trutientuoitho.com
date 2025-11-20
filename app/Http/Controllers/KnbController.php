<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Vip;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class KnbController extends Controller
{

    public function getKnb()
    {
        $knbs = Transaction::where("user_id", Auth::user()->id)->whereIn("type", ["knb", "war_knb"])->latest()->get();
        $sum  = Transaction::where("user_id", Auth::user()->id)->whereIn("type", ["knb", "war_knb"])->sum("knb_amount");
        $sum  = number_format($sum);
        return view("account.knb", ["knbs" => $knbs, "sum" => $sum]);
    }

    private function isWaiting()
    {
        $now = Carbon::now();

        $lastRecord = Vip::where("user_id", Auth::user()->id)->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return true;
            }

        }

        $lastRecord = Transaction::where("user_id", Auth::user()->id)->where("type", "knb")->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return true;
            }

        }

        $lastRecord = Transaction::where("user_id", Auth::user()->id)->where("type", "war_knb")->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return true;
            }

        }
        return false;
    }

    public function postKnb()
    {
        $xu = request()->xu;
        $user = current_user();
        if ($xu < 30000 || $xu > $user->balance) {
            return back()->with("error", "Số xu nạp phải lớn hơn 30.000 và nhỏ hơn số xu hiện có!");
        }

        try {
            DB::beginTransaction();
            $this->callGameApi("POST", "/api/knb.php", [
                "userid" => $user->userid,
                "cash"   => intval($xu / 10),
            ]);
            $user->balance = intval($user->balance) - $xu;
            $user->save();

            $transaction             = new Transaction;
            $transaction->user_id    = $user->id;
            $transaction->knb_amount = intval($xu / 1000);
            $transaction->type       = "knb";
            $transaction->save();
            DB::commit();
            return back()->with("success", "Đã chuyển " . intval($xu / 1000) . " KNB vào game thành công!");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}
