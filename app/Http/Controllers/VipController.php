<?php
namespace App\Http\Controllers;

use App\Models\AutoVip;
use App\Models\Transaction;
use App\Models\Vip;
use App\Models\VipAward;
use Auth;
use Carbon\Carbon;
use DB;

class VipController extends Controller
{
    public function index()
    {
        $now  = Carbon::now();
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

    public function vip()
    {
        $configs = [
            [
                "title"  => "Sơ Cấp Linh Thạch",
                "code"   => "linh_thach",
                "itemid" => 81330,
                "data"   => [
                    "6" => 250,
                    "7" => 500,
                    "8" => 1000,
                ],
            ],
            [
                "title"  => "Mảnh Ghép Thiên Quan Tứ Phúc",
                "code"   => "manh_ghep",
                "itemid" => 52174,
                "data"   => [
                    "6" => 20,
                    "7" => 30,
                    "8" => 50,
                ],
            ],
            [
                "title"  => "Ngân Phiếu 5000 vàng",
                "code"   => "vang",
                "itemid" => 78041,
                "data"   => [
                    "6" => 10,
                    "7" => 20,
                    "8" => 30,
                ],
            ],
            [
                "title"  => "Vé vào Vô Song Thành",
                "code"   => "vst",
                "itemid" => 84142,
                "data"   => [
                    "6" => "Vô Hạn",
                    "7" => "Vô Hạn",
                    "8" => "Vô Hạn",
                ],
            ],
        ];
        $done1 = VipAward::where("user_id", current_user()->id)
            ->where("code", "linh_thạch")
            ->whereDate('date', Carbon::today())
            ->first() ? "done" : "undone";
        $done2 = VipAward::where("user_id", current_user()->id)
            ->where("code", "manh_ghep")
            ->whereDate('date', Carbon::today())
            ->first() ? "done" : "undone";
        $done3 = VipAward::where("user_id", current_user()->id)
            ->where("code", "vang")
            ->whereDate('date', Carbon::today())
            ->first() ? "done" : "undone";
        $done4 = VipAward::where("user_id", current_user()->id)
            ->where("code", "hong_loi")
            ->whereDate('date', Carbon::today())
            ->first() ? "done" : "undone";
        $done5 = VipAward::where("user_id", current_user()->id)
            ->where("code", "vst")
            ->whereDate('date', Carbon::today())
            ->first() ? "done" : "undone";

        $configs = [
            [
                "title"  => "Sơ Cấp Linh Thạch",
                "code"   => "linh_thach",
                "status" => $done1,
                "data"   => [
                    "6" => 100,
                    "7" => 200,
                    "8" => 400,
                ],
            ],
            [
                "title"  => "Mảnh Ghép Thiên Quan Tứ Phúc",
                "code"   => "manh_ghep",
                "status" => $done2,
                "data"   => [
                    "6" => 15,
                    "7" => 25,
                    "8" => 40,
                ],
            ],
            [
                "title"  => "Ngân Phiếu 5000 vàng",
                "code"   => "vang",
                "status" => $done3,
                "data"   => [
                    "6" => 5,
                    "7" => 10,
                    "8" => 20,
                ],
            ],
            [
                "title"  => "Hồng Lợi 15KNB",
                "code"   => "hong_loi",
                "status" => $done4,
                "data"   => [
                    "6" => 2,
                    "7" => 3,
                    "8" => 5,
                ],
            ],
            [
                "title"  => "Vé vào Vô Song Thành",
                "code"   => "vst",
                "itemid" => 84142,
                "status" => $done5,
                "data" => [
                        "6" => 30,
                        "7" => 50,
                        "8" => 10000,
                    ]
            ],
        ];

        return view("vips.vip", compact("configs", "done1", "done2", "done3", "done4", "done5"));
    }

    public function postVip($code)
    {

        $user      = Auth::user();
        $questUser = VipAward::where("user_id", current_user()->id)
            ->where("char_id", current_user()->main_id)
            ->where("code", $code)
            ->whereDate('date', Carbon::today())
            ->first();
        if (! $questUser) {
            $vip = $user->viplevel;
            if ($vip < 6) {
                return back()->withErrors(["Chỉ dành cho VIP từ cấp 6 trở lên!"]);
            }

            $msg            = "Không đủ điều kiện hoàn thành nhiệm vụ này!";
            $award          = new VipAward;
            $award->user_id = current_user()->id;
            $award->char_id = current_user()->main_id;
            $award->code    = $code;
            $award->date    = Carbon::today();
            $award->save();
            switch ($code) {
                case 'linh_thach':
                    $data = [
                        "6" => 250,
                        "7" => 500,
                        "8" => 1000,
                    ];
                    $this->callGameApi("POST", "/api/mail.php", [
                        "receiver" => $user->main_id,
                        "itemid"   => 81330,
                        "count"    => $data[$vip],
                        "proctype" => 19,
                        "msg"      => "[NPH] Quà tặng đặc quyền VIP hàng ngày",
                    ]);
                    break;
                case 'manh_ghep':
                    # code...
                    $data = [
                        "6" => 20,
                        "7" => 30,
                        "8" => 50,
                    ];
                    $this->callGameApi("POST", "/api/mail.php", [
                        "receiver" => $user->main_id,
                        "itemid"   => 58577,
                        "count"    => $data[$vip],
                        "proctype" => 19,
                        "msg"      => "[NPH] Quà tặng đặc quyền VIP hàng ngày",
                    ]);
                    break;
                case 'vang':
                    $data = [
                        "6" => 10,
                        "7" => 20,
                        "8" => 30,
                    ];
                    $this->callGameApi("POST", "/api/mail.php", [
                        "receiver" => $user->main_id,
                        "itemid"   => 78041,
                        "count"    => $data[$vip],
                        "proctype" => 19,
                        "msg"      => "[NPH] Quà tặng đặc quyền VIP hàng ngày",
                    ]);
                    # code...
                    break;
                case 'hong_loi':
                    $data = [
                        "6" => 2,
                        "7" => 3,
                        "8" => 5,
                    ];
                    $this->callGameApi("POST", "/api/mail.php", [
                        "receiver" => $user->main_id,
                        "itemid"   => 52174,
                        "count"    => $data[$vip],
                        "proctype" => 19,
                        "msg"      => "[NPH] Quà tặng đặc quyền VIP hàng ngày",
                    ]);
                    # code...
                    break;
                case 'vst':
                    $data = [
                        "6" => 30,
                        "7" => 50,
                        "8" => 10000,
                    ];
                    $this->callGameApi("POST", "/api/mail.php", [
                        "receiver" => $user->main_id,
                        "itemid"   => 84142,
                        "count"    => $data[$vip],
                        "proctype" => 19,
                        "expire"   => 24*60,
                        "msg"      => "[NPH] Quà tặng đặc quyền VIP hàng ngày",
                    ]);

                default:
                    # code...
                    break;
            }
            return back()->with("success", "Bạn đã nhận quà hôm nay thành công!");
        } else {
            return back()->withErrors(["Bạn đã nhận quà hôm nay rồi!"]);
        }
    }

    public function store()
    {
        $type = request()->type;
        $xu   = $type == "week" ? 100000 : 500000;
        if (Auth::user()->balance < $xu) {
            return back()->with("error", "Số xu trong tài khoản không đủ để mua gói này!");
        }

        if (! Auth::user()->main_id) {
            return back()->with("error", "Vui lòng chọn nhân vật chính trước!");
        }
        $now        = Carbon::now();
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
            $user            = Auth::user();
            $vip             = new Vip;
            $vip->type       = $type;
            $vip->user_id    = Auth::user()->id;
            $vip->start_date = Carbon::now()->format("Y-m-d");
            $vip->end_date   = $type == "week" ? Carbon::now()->addDays(7)->format("Y-m-d") : Carbon::now()->addMonth()->format("Y-m-d");
            $vip->save();
            $user->balance = $user->balance - $xu;
            $user->save();

            $this->callGameApi("POST", "/api/knb.php", [
                "userid" => $user->userid,
                "cash"   => intval($xu / 10),
            ]);

            $hongLoi5 = 52173;
            $msg      = $type == "week" ? "[Gói Đầu Tư Tuần] Hồng Lợi" : "[Gói Đầu Tư Tháng] Hồng Lợi";
            $this->callGameApi("post", "/api/mail.php", [
                "receiver" => $user->main_id,
                "itemid"   => $hongLoi5,
                "count"    => $type == "week" ? 1 : 4,
                "proctype" => \App\Models\Mail::BIND_TYPES["BIND"],
                "msg"      => $msg,
            ]);
            $auto = AutoVip::where("vip_id", $vip->id)->whereDate("date", $now)->first();
            if (! $auto) {
                $newAuto         = new AutoVip;
                $newAuto->vip_id = $vip->id;
                $newAuto->date   = date("Y-m-d");
                $newAuto->save();
            }

            $transaction             = new Transaction;
            $transaction->user_id    = $user->id;
            $transaction->knb_amount = $xu;
            $transaction->type       = "vip";
            $transaction->vip_id     = $vip->id;
            $transaction->save();

            DB::commit();
            return back()->with("success", "Mua thành công !");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}
