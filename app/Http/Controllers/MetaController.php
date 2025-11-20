<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class MetaController extends Controller
{

    public function create()
    {
        return view('auth.meta');
    }

    private function hasMeta($userId)
    {
        return Meta::where("user_id", $userId)->orWhere("meta_user_id", $userId)->first();
    }

    private function isMainMeta() {
        return Meta::where("user_id", Auth::user()->id)->first();
    }

    public function store()
    {
        $newAccount = User::where("username", request()->username)->where("password2", request()->password)->first();

        if (!$newAccount) {
            return back()->with("error", "Thông tin tài khoản phụ không chính xác");
        }

        if ($this->hasMeta($newAccount->id)) {
            return back()->with("error", "Tài khoản thuộc về meta khác");
        }

        if (Meta::where("meta_user_id", Auth::user()->id)->first() && !$this->isMainMeta()) {
            return back()->with("error", "Chỉ tài khoản chính mới có thể thêm");
        }

        $main = Meta::where("user_id", Auth::user()->id)->first();
        if (!$main) {
            $m2 = Meta::where("meta_user_id", $newAccount->id)->first();
            if (!$m2) {
                $meta = new Meta;
                $meta->meta_user_id = $newAccount->id;
                $meta->user_id = Auth::user()->id;
                $meta->save();
                return back()->with("success", "Thêm thành công");
            } else {
                return back()->with("error", "Chỉ tài khoản chính mới có thể thêm");
            }
        } else {
            $meta = new Meta;
            $meta->user_id = Auth::user()->id;
            $meta->meta_user_id = $newAccount->id;
            $meta->save();
            return back()->with("success", "Thêm thành công");
        }

        return back()->with("success", "Cập nhật thành công");
    }

    public function delete($id)
    {
        $meta = Meta::where("meta_user_id", $id)->first();
        if (!$meta) {
            return back()->with("error", "Không thể xoá tài khoản chính");
        }
        if ($meta->user_id != Auth::user()->id) {
            return back()->with("error", "Chỉ tài khoản chính mới có thể xoá");
        }
        $meta->delete();
        return back()->with("success", "Xoá thành công");
    }

    public function login($id)
    {
        $users = meta()->pluck("id")->toArray();
        if (!in_array($id, $users)) {
            return back();
        }
        Auth::loginUsingId($id);
        return back();
    }

}
