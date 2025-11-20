<?php

namespace App\Http\Controllers;

use App\Models\Char;
use Auth;
use hrace009\PerfectWorldAPI\API;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $need = current_user()->viplevel * 10000;
        return view("services", compact("need"));
    }

    public function updateVip()
    {
        if (isRoleOnline(Auth::user()->main_id)) {
            return back()->with("error", "Phải thoát game trước khi thực hiện tính năng này!");
        }
        $this->callGameApi("get", "/api/vip-update.php?userid=".Auth::user()->userid, []);
        return back()->with("success", "Cập nhật thành công, đăng nhập vào game lại để kiểm tra");
    }

    public function addVip()
    {
        if (isRoleOnline(Auth::user()->main_id)) {
            return back()->with("error", "Phải thoát game trước khi thực hiện tính năng này!");
        }
        $user = Auth::user();
        $need = $user->viplevel * 10000;
        if ($user->balance < $need) {
            return back()->with("error", "Duy trì số dư là {$need} xu để gia hạn (không tốn phí)!");
        }
        $res = $this->callGameApi("get", "/api/vip-add.php?userid=".Auth::user()->userid, []);
        if($res["data"]["extended"] == false) {
            return back()->with("error", "Vip vẫn còn thời hạn, vui lòng kiểm tra lại!");
        }
        return back()->with("success", "Cập nhật thành công, đăng nhập vào game lại để kiểm tra");
    }

    public function checkOnline()
    {
        $char = Char::where("char_id", request()->char_id)->first();
        if (!$char) {
            return back()->with("error", "Nhân vật không tồn tại!");
        }
        $online = roleOnline(request()->char_id);
        if (!$online) {
            return back()->with("error", "Người chơi " . $char->name . " đang không trực tuyến!");
        }
        return back()->with("success", "Người chơi " . $char->name . " đang online!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function quangBa($id)
    {
        $user = Auth::user();
        $role = $user->main_id;
        $message = request()->message;

        if ($user->balance >= 1000) {
            if (roleOnline($role)) {
                $api = new API();
                $typeX = $id == 1 ? 9 : 20;
                $price = $id == 1 ? 1000 : 5000;
                if ($api->worldChat($role, $message, $typeX)) {
                    $user->balance = $user->balance - $price;
                    $user->save();

                    $type = 'success';
                    $note = "Đã gửi thông báo thành công!";
                } else {
                    $type = 'error';
                    $note = "Máy chủ đang không hoạt động";
                }
            } else {
                $type = 'error';
                $note = "Nhân vật phải đang đăng nhập trong game!";
            }
        } else {
            $type = 'error';
            $note = "Số xu của bạn không đủ";
        }

        return redirect()->back()->with($type, $note);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
