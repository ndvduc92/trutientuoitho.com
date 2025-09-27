<?php

namespace App\Http\Controllers;

use App\Mail\ChangeEmail;
use App\Models\Otp;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ChangeEmailController extends Controller
{
    private function getRandomStringRandomInt($length = 32)
    {
        $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = mb_strlen($stringSpace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $stringSpace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    private function getOtp($n)
    {
        $generator = "0123456789";

        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        return $result;
    }

    public function getChange()
    {
        return view("change-email");
    }

    public function sendOtp()
    {
        $pass = Otp::where("user_id", Auth::user()->id)->where("type", "change-email")->first();
        if ($pass) {
            $pass->otp = $this->getOtp(8);
            $pass->expired = \Carbon\Carbon::now()->addMinutes(5)->format("Y-m-d H:i:s");
            $pass->save();
        } else {
            $pass = new Otp;
            $pass->otp = $this->getOtp(8);
            $pass->type = "change-email";
            $pass->user_id = Auth::user()->id;
            $pass->expired = \Carbon\Carbon::now()->addMinutes(5)->format("Y-m-d H:i:s");
            $pass->save();
        }
        Mail::to(Auth::user()->email2)->send(new ChangeEmail($pass, Auth::user()));
        return response()->json(null, 200);
    }

    public function postChange(Request $request)
    {
        $validated = $request->validate([
            'old' => 'bail|required',
            'new' => 'bail|required',
            'otp' => 'bail|required',
        ]);
        $user = \Auth::user();
        if ($request->old == $user->email2) {
            $pass = Otp::where("user_id", Auth::user()->id)->where("otp", $request->otp)->first();
            if (!$pass || ($pass && \Carbon\Carbon::now()->greaterThan($pass->expired))) {
                return back()->with("error", "Mã OTP không đúng hoặc hết hạn!");
            }
            try {
                $user->email2 = $request->new;
                $user->save();
                $pass->otp = "";
                $pass->save();
                return redirect("/ca-nhan")->with("success", "Đổi email thành công!");
            } catch (\Throwable $th) {
                DB::rollback();
                return back()->with("error", "Đã có lỗi xảy ra, vui lòng liên hệ với GM!");
            }
        }
        return back()->with("error", "Email hiện tại không đúng!");
    }
}
