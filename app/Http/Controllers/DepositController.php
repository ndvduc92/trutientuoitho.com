<?php
namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Promotion;
use Auth;
use Carbon\Carbon;

class DepositController extends Controller
{
    public function histories()
    {
        $histories = Deposit::where("user_id", Auth::user()->id)->latest()->get();
        return view("deposit_history", ["histories" => $histories]);
    }

    public function getNapTien()
    {
        $response = $this->callGameApi("get", "/api/vip.php", []);
        $data     = $response["data"];
        $vip      = collect($data)->firstWhere("userid", current_user()->userid);
        $total    = 0;
        if ($vip) {
            $total = $vip["totalcash"];
        }

        $vips = [
            [
                "level" => 1,
                "knb"   => 100,
                "xu"    => 100,
            ],
            [
                "level" => 2,
                "knb"   => 400,
                "xu"    => 400,
            ],
            [
                "level" => 3,
                "knb"   => 800,
                "xu"    => 1,
            ],
            [
                "level" => 4,
                "knb"   => 1500,
                "xu"    => 1,
            ],
            [
                "level" => 5,
                "knb"   => 2500,
                "xu"    => 1,
            ],
            [
                "level" => 6,
                "knb"   => 6000,
                "xu"    => 1,
            ],
            [
                "level" => 7,
                "knb"   => 8000,
                "xu"    => 1,
            ],
            [
                "level" => 8,
                "knb"   => 15000,
                "xu"    => 1,
            ],
        ];
        $now              = Carbon::now();
        $histories        = Deposit::where("user_id", Auth::user()->id)->where("is_revenue", 1)->latest()->get();
        $sum              = Deposit::where("user_id", Auth::user()->id)->where("is_revenue", 1)->sum("amount");
        $currentPromotion = Promotion::where('start_time', '<=', $now)->where('end_time', '>=', $now)->first();
        $img              = "https://qr.sepay.vn/img?template=compact&acc=96247TTVN&bank=BIDV&des=TTVN" . strtoupper(Auth::user()->username);
        return view("deposit", [
            "currentPromotion" => $currentPromotion,
            "img"              => $img,
            "histories"        => $histories,
            "sum"              => $sum,
            "vips" => $vips,
            "total" => $total
        ]);
    }
}
