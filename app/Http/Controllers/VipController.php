<?php

namespace App\Http\Controllers;

use App\Models\AutoVip;
use App\Models\Vip;
use Auth;
use Carbon\Carbon;
use App\Models\Transaction;
use DB;

class VipController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $week = Vip::where("type", "week")
            ->where("user_id", Auth::user()->id)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->first();
        $month = Vip::where("type", "month")
            ->where("user_id", Auth::user()->id)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->first();
        return view("vips.index", compact("week", "month"));

    }

    public function store()
    {
        $type = request()->type;
        $xu = $type == "week" ? 100000 : 500000;
        if (Auth::user()->balance < $xu) {
            return back()->with("error", "Số xu trong tài khoản không đủ để mua gói này!");
        }

        if (!Auth::user()->main_id) {
            return back()->with("error", "Vui lòng chọn nhân vật chính trước!");
        }
        $now = Carbon::now();
        $lastRecord = Vip::where("user_id", Auth::user()->id)->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return back()->with("error", "Thao tác quá nhanh, quay lại sau vài phút nữa nhé!!!");
            }

        }
        $week = Vip::where("type", $type)
            ->where("user_id", Auth::user()->id)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->first();

        if ($week) {
            return back()->with("error", "Bạn đã mua gói này rồi!!!");
        }
        try {
            $user = Auth::user();
            $vip = new Vip;
            $vip->type = $type;
            $vip->user_id = Auth::user()->id;
            $vip->start_date = Carbon::now()->format("Y-m-d");
            $vip->end_date = $type == "week" ? Carbon::now()->addDays(7)->format("Y-m-d") : Carbon::now()->addMonth()->format("Y-m-d");
            $vip->save();
            $user->balance = $user->balance - $xu;
            $user->save();

            $this->callGameApi("POST", "/api/knb.php", [
                "userid" => $user->userid,
                "cash" => intval($xu / 10),
            ]);

            $hongLoi5 = 52173;
            $msg = $type == "week" ? "[Gói Đầu Tư Tuần] Hồng Lợi" : "[Gói Đầu Tư Tháng] Hồng Lợi";
            $this->callGameApi("post", "/api/mail.php", [
                "receiver" => $user->main_id,
                "itemid" => $hongLoi5,
                "count" => $type == "week" ? 1 : 4,
                "proctype" => \App\Models\Mail::BIND_TYPES["BIND"],
                "msg" => $msg,
            ]);
            $auto = AutoVip::where("vip_id", $vip->id)->whereDate("date", $now)->first();
            if (!$auto) {
                $newAuto = new AutoVip;
                $newAuto->vip_id = $vip->id;
                $newAuto->date = date("Y-m-d");
                $newAuto->save();
            }

            $transaction = new Transaction;
            $transaction->user_id = $user->id;
            $transaction->knb_amount = $xu;
            $transaction->type = "vip";
            $transaction->vip_id = $vip->id;
            $transaction->save();

            DB::commit();
            return back()->with("success", "Mua thành công !");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}
