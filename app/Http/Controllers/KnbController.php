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
        return view("knb", ["knbs" => $knbs, "sum" => $sum]);
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
        $type = request()->type;
        if (! (in_array($type, ["knb", "war"]))) {
            return back()->with("error", "Vui lòng chọn loại xu trước!!");
        }

        if (! isOnline()) {
            return back()->with("error", "Server chưa hoạt động. Vui lòng quay lại sau.");
        }

        if ($this->isWaiting()) {
            return back()->with("error", "Thao tác quá nhanh, quay lại sau vài phút nữa nhé!!!");
        }
        $user = Auth::user();
        $xu   = request()->cash;
        if ($type == "war") {
            if ($xu < 10 || $user->warCoin() < $xu) {
                return back()->with("error", "Số xu war không đủ!");
            }

            try {
                DB::beginTransaction();
                $this->callGameApi("POST", "/api/knb.php", [
                    "userid" => $user->userid,
                    "cash"   => intval($xu * 100) * 3,
                ]);
                $user->war_point_used = intval($user->war_point_used) + $xu;
                $user->save();

                $transaction             = new Transaction;
                $transaction->user_id    = $user->id;
                $transaction->knb_amount = $xu * 3;
                $transaction->type       = "war_knb";
                $transaction->save();
                DB::commit();
                return back()->with("success", "Đã chuyển " . intval($xu) * 3 . " KNB vào game thành công!");
            } catch (\Throwable $th) {
                DB::rollback();

                return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
            }
        }
        if ($xu < 30000 || $xu > $user->balance) {
            return back()->with("error", "Số xu nạp phải lớn hơn 30.000 và nhỏ hơn số xu hiện có!");
        }

        try {
            DB::beginTransaction();
            $this->callGameApi("POST", "/api/knb.php", [
                "userid" => $user->userid,
                "cash"   => intval($xu / 10) * 3,
            ]);
            $user->balance = intval($user->balance) - $xu;
            $user->save();

            $transaction             = new Transaction;
            $transaction->user_id    = $user->id;
            $transaction->knb_amount = intval($xu / 1000) * 3;
            $transaction->type       = "knb";
            $transaction->save();
            DB::commit();
            return back()->with("success", "Đã chuyển " . intval($xu / 1000) * 3 . " KNB vào game thành công!");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}
