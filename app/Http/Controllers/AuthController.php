<?php
namespace App\Http\Controllers;

use App\Models\Change;
use App\Models\Char;
use App\Models\CharItem;
use App\Models\Item;
use App\Models\Title;
use App\Models\Trade;
use App\Models\User;
use App\Services\CharService;
use Auth;
use DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function profile()
    {
        return view('auth.profile');
    }

    public function inventory()
    {
        return view('auth.inventory', [
            'items' => CharItem::where("char_id", current_user()->main_id)->with("item")->get(),
        ]);
    }

    public function getItem(Request $request)
    {
        $item = CharItem::where("char_id", current_user()->main_id)->findOrFail($request->shop_id);

        $remaining = $item->quantity;

        while ($remaining > 0) {
            $batch = min($item->stack, $remaining);

            $this->callGameApi("post", "/api/mail.php", [
                "receiver" => current_user()->main_id,
                "itemid"   => $item->itemid,
                "count"    => $batch,
                "proctype" => 19,
                "msg"      => "[Túi đồ][" . $item->item->name . "] x" . $batch,
            ]);

            $remaining -= $batch;
        }

        $item->delete();

        return back()->with('success', 'Đã lấy vật phẩm thành công!');
    }

    public function signup()
    {

// Test database connection
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" . $e);
        }
        if (Auth::check()) {
            return redirect("/");
        }
        return view('auth.signup');
    }

    public function signin()
    {
        if (request()->token) {
            Auth::logout();
            $user = User::whereNotNull("admin_login_token")->where("admin_login_token", request()->token)->first();
            if ($user) {
                Auth::loginUsingId($user->id);
                $user->admin_login_token = "";
                $user->save();
                return redirect("/");
            }
        }
        if (Auth::check()) {
            $user             = Auth::user();
            $user->last_login = date("Y-m-d H:i:s");
            $user->save();
            return redirect("/");
        }
        return view('auth.signin');
    }

    public function chars()
    {
        if (! isOnline()) {
            return back()->with("error", "Server không hoạt động.");
        }
        (new CharService())->chars();
        return back()->with("success", "Cập nhật thành công");

    }

    public function fastSignup()
    {
        if (Auth::check()) {
            return redirect("/");
        }
        return view('auth.fast-signup');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function signupPost(Request $request)
    {
        $validated = $request->validate([
            'login'         => 'bail|required|min:3|max:10|alpha_num|unique:users,username',
            'passwd'        => 'bail|required|min:4|max:10|alpha_num',
            'passwdConfirm' => 'bail|required|same:passwd',
            'email'         => 'bail|required|email|unique:users,email',
            'captcha'       => ['required', 'captcha'],
        ], [
            "login.min"          => "Tên đăng nhập chỉ được chứa từ 3 - 10 kí tự",
            "login.max"          => "Tên đăng nhập chỉ được chứa từ 3 - 10 kí tự",
            "login.alpha_num"    => "Tên đăng nhập chỉ được chứa chữ và số",
            "login.unique"       => "Tên đăng nhập đã được sử dụng",
            "passwd.min"         => "Mật khẩu chỉ được chứa từ 3 - 10 kí tự",
            "passwd.max"         => "Mật khẩu chỉ được chứa từ 3 - 10 kí tự",
            "passwd.alpha_num"   => "Mật khẩu chỉ được chứa chữ và số",
            "passwdConfirm.same" => "Mật khẩu nhập lại không đúng",
            "captcha.captcha"    => "Mã xác thực không đúng",
        ]);
        sleep(0.5);
        $gameEmail = $request->login . "." . time() . "@gmail.com";
        $content   = $this->callGameApi("POST", "/api/reg.php", [
            "login"    => strtolower($request->login),
            "passwd"   => $request->passwd,
            "repasswd" => $request->passwd,
            "email"    => $gameEmail,
        ]);
        if ($content["success"]) {
            $user                    = new User;
            $user->name              = strtolower($request->login);
            $user->email2            = strtolower($request->email);
            $user->username          = strtolower($request->login);
            $user->userid            = $content["userid"];
            $user->email             = $gameEmail;
            $user->password2         = $request->passwd;
            $user->password          = \Hash::make($request->passwd);
            $user->email_verified_at = date("Y-m-d H:i:s");
            $user->save();
            //$this->sendMessage("Người chơi " . $request->login . " vừa đăng ký tài khoản");
            return back()->with("success", "Tạo tài khoản thành công!");
        } else {
            return back()->with("error", "Tên đăng nhập đã tồn tại!");
        }
    }

    public function fastSignupPost(Request $request)
    {
        $validated = $request->validate([
            'login'         => 'bail|required|min:2|max:8|alpha_num',
            'passwd'        => 'bail|required|min:4|max:10|alpha_num',
            'passwdConfirm' => 'bail|required|same:passwd',
            'email'         => 'bail|required|email',
            'count'         => 'bail|required',
            'captcha'       => ['required', 'captcha'],
        ], [
            "login.min"          => "Tên đăng nhập chỉ được chứa từ 3 - 8 kí tự",
            "login.max"          => "Tên đăng nhập chỉ được chứa từ 3 - 8 kí tự",
            "login.alpha_num"    => "Tên đăng nhập chỉ được chứa chữ và số",
            "login.unique"       => "Tên đăng nhập đã được sử dụng",
            "passwd.min"         => "Mật khẩu chỉ được chứa từ 3 - 10 kí tự",
            "passwd.max"         => "Mật khẩu chỉ được chứa từ 3 - 10 kí tự",
            "passwd.alpha_num"   => "Mật khẩu chỉ được chứa chữ và số",
            "passwdConfirm.same" => "Mật khẩu nhập lại không đúng",
            "captcha.captcha"    => "Mã xác thực không đúng",
        ]);
        $users  = [];
        $exists = [];
        if ($request->count > 20 || $request->count < 1) {
            return back()->with("error", "Tối đa chỉ được đăng ký 1->20 tài khoản cùng 1 lúc");
        }

        $i     = 1;
        $exist = [2, 4, 5];
        while (count($users) < $request->count) {
            $exist = User::where("username", $request->login . strval($i))->first();
            if (! $exist) {
                $users[] = $request->login . strval($i);
            } else {
                $exists[] = $request->login . strval($i);
            }

            $i++;
        }
        $login   = strtolower($request->login);
        $email   = strtolower($request->email);
        $success = [];
        try {
            DB::beginTransaction();
            foreach ($users as $username) {
                $gameEmail = getRandomStringRandomInt(10) . "@gmail.com";
                $content   = $this->callGameApi("POST", "/api/reg.php", [
                    "login"    => strtolower($username),
                    "passwd"   => $request->passwd,
                    "repasswd" => $request->passwd,
                    "email"    => strtolower($gameEmail),
                ]);
                if ($content["success"]) {
                    $user                    = new User;
                    $user->name              = strtolower($username);
                    $user->email2            = strtolower($email);
                    $user->username          = strtolower($username);
                    $user->userid            = $content["userid"];
                    $user->email             = $gameEmail;
                    $user->password2         = $request->passwd;
                    $user->password          = \Hash::make($request->passwd);
                    $user->email_verified_at = date("Y-m-d H:i:s");
                    $user->save();
                }
            }
            $msg = "<p style='color: greenyellow'>Tạo thành công " . implode(', ', $users) . "</p>";
            if (count($exists)) {
                $msg .= "<p style='color:red'>Tài khoản " . implode(', ', $exists) . " đã tồn tại nên bỏ qua</p>";
            }
            DB::commit();
            return back()->with("success", $msg);

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }

    }

    public function signinPost(Request $request)
    {
        $validated = $request->validate([
            'login'    => 'bail|required',
            'password' => 'bail|required',
        ], [
            "login.required" => "Tên đăng nhập chỉ được chứa từ 3 - 10 kí tự",
        ]);
        $login = [
            'username' => $request->login,
            'password' => $request->password,
        ];
        if (\Auth::attempt($login)) {
            try {
                $user     = Auth::user();
                $response = $this->callGameApi("get", "/api/vip.php", []);
                $data     = $response["data"];
                $vip      = current(array_filter($data, function ($e) use ($user) {
                    return $e["userid"] == $user->userid;
                }));
                if ($vip) {
                    $user->viplevel = $vip["viplevel"];
                    $user->save();
                }
            } catch (\Throwable $th) {
            }
            $user             = Auth::user();
            $user->last_login = date("Y-m-d H:i:s");
            $user->save();
            return redirect('/');
        } else {
            return redirect("/dang-nhap")->with('error', 'Thông tin đăng nhập không chính xác');
        }
    }

    public function setMainChar($id)
    {
        $user          = Auth::user();
        $user->main_id = $id;
        $user->save();
        return back();
    }

    public function changeClassGet()
    {
        return view("class");
    }

    public function title()
    {
        return view("title", ["titles" => Title::with("char")->latest()->get()]);
    }

    public function postTitle()
    {
        $user = Auth::user();
        if ($user->balance < 200000) {
            return back()->with("error", "Số dư xu trong tài khoản không đủ!");
        }

        $user->balance = intval($user->balance) - 200000;
        $user->save();
        $title          = new Title;
        $title->title   = request()->title;
        $title->color   = request()->color;
        $title->user_id = current_user()->id;
        $title->char_id = current_user()->main_id;
        $title->save();
        $name = current_user()->char->name;
        $tit  = request()->title;
        $msg  = "[{$name}] đã đăng ký tôn hiệu riêng [{$tit}]";
        return back()->with("success", "Đã đăng ký tôn hiệu thành công");
    }

    public function event()
    {
        return view("class-free");
    }

    public function nhanVat()
    {
        try {
            $uid = current_user()->main_id;
            if (request()->has('char_id')) {
                $uid = request()->get('char_id');
            }
            $response = $this->callGameApi("get", "/api/char.php?uid={$uid}", []);

            $category       = request()->get('category', 'equipment');
            $bagData        = [];
            $storeData      = [];
            $equipmentData  = [];
            $equipmentData2 = [];
            $fashionData    = [];
            $fashionData2   = [];
            $info           = $response["status"];
            $base           = $response["base"];
            $trades         = [];

            switch ($category) {
                case 'bag':
                    $invMapBag = collect($response["items"])->pluck('count', 'id'); // [3999 => 1, 58187 => 1, ...]
                    $bagItems  = Item::whereIn("itemid", collect($response["items"])->pluck("id")->toArray())->get();
                    $bagData   = collect($bagItems)->map(function ($item) use ($invMapBag) {
                        $item['count'] = $invMapBag[$item['itemid']] ?? 0;
                        return $item;
                    });

                    $bagData = array_chunk($bagData->toArray(), 6);
                    break;
                case 'equipment':
                    $equipmentItems  = Item::whereIn("itemid", collect($response["equipment"])->pluck("id")->toArray())->get();
                    $invMapEquipment = collect($response["equipment"])->pluck('pos', 'id'); // [3999 => 1, 58187 => 1, ...]
                    $equipmentData   = collect($equipmentItems)->map(function ($item) use ($invMapEquipment) {
                        $item['pos'] = $invMapEquipment[$item['itemid']] ?? 0;
                        return $item;
                    });

                    $equipmentData2 = array_chunk($equipmentData->toArray(), 6);

                    $equipmentData = $equipmentData->toArray();
                    break;
                case 'inventory':
                    $storehouseItems = Item::whereIn("itemid", collect($response["storehouse"])->pluck("id")->toArray())->get();
                    $invMapStore     = collect($response["storehouse"])->pluck('count', 'id'); // [3999 => 1, 58187 => 1, ...]

                    $storeData = collect($storehouseItems)->map(function ($item) use ($invMapStore) {
                        $item['count'] = $invMapStore[$item['itemid']] ?? 0;
                        return $item;
                    });

                    $storeData = array_chunk($storeData->toArray(), 6);
                    break;
                case 'trades':
                    $uid    = current_user()->main_id;
                    $trades = Trade::with("items")->where("from_char_id", $uid)->orWhere("to_char_id", $uid)->orderBy("date", "desc")->get();
                    break;
                default:
                    # code...
                    break;
            }

            $fashionItems  = Item::whereIn("itemid", collect($response["fashion"])->pluck("id")->toArray())->get();
            $invMapFashion = collect($response["fashion"])->pluck('pos', 'id'); // [3999 => 1, 58187 => 1, ...]
            $fashionData   = collect($fashionItems)->map(function ($item) use ($invMapFashion) {
                $item['pos'] = $invMapFashion[$item['itemid']] ?? 0;
                return $item;
            });

            $fashionData = $fashionData->toArray();
            $char        = Char::where("char_id", $uid)->first();
            return view("chars", compact("char", "trades", "base", "bagData", "info", "storeData", "equipmentData", "equipmentData2", "fashionData"));
        } catch (\Throwable $th) {
            return redirect("/")->with("error", "Thông tin nhân vật chưa được cập nhật!");
        }
    }

    public function search($uid)
    {
        // $name = request()->get("name", "");
        // if (empty($name)) {
        //     return back()->with("error", "Vui lòng nhập tên nhân vật cần tìm kiếm");
        // }
        // $chars = $this->callGameApi("get", "/api/char.php?search={$name}", []);
        // if (! $chars["success"]) {
        //     return back()->with("error", "Không tìm thấy nhân vật nào với tên {$name}");
        // }
        try {
            $response = $this->callGameApi("get", "/api/char.php?uid={$uid}", []);

            $category       = request()->get('category', 'equipment');
            $equipmentData  = [];
            $equipmentData2 = [];
            $fashionData    = [];
            $fashionData2   = [];
            $info           = $response["status"];
            $base           = $response["base"];

            switch ($category) {
                case 'equipment':
                    $equipmentItems  = Item::whereIn("itemid", collect($response["equipment"])->pluck("id")->toArray())->get();
                    $invMapEquipment = collect($response["equipment"])->pluck('pos', 'id'); // [3999 => 1, 58187 => 1, ...]
                    $equipmentData   = collect($equipmentItems)->map(function ($item) use ($invMapEquipment) {
                        $item['pos'] = $invMapEquipment[$item['itemid']] ?? 0;
                        return $item;
                    });

                    $equipmentData2 = array_chunk($equipmentData->toArray(), 6);

                    $equipmentData = $equipmentData->toArray();
                    break;
                default:
                    # code...
                    break;
            }

            $fashionItems  = Item::whereIn("itemid", collect($response["fashion"])->pluck("id")->toArray())->get();
            $invMapFashion = collect($response["fashion"])->pluck('pos', 'id'); // [3999 => 1, 58187 => 1, ...]
            $fashionData   = collect($fashionItems)->map(function ($item) use ($invMapFashion) {
                $item['pos'] = $invMapFashion[$item['itemid']] ?? 0;
                return $item;
            });

            $fashionData = $fashionData->toArray();
            $char        = Char::where("char_id", $uid)->first();
            return view("search", compact("char", "base", "info", "equipmentData", "equipmentData2", "fashionData"));
        } catch (\Throwable $th) {
            return $th;
            return redirect("/")->with("error", "Thông tin nhân vật chưa được cập nhật!");
        }
        return view("search");
    }

    public function changeClassPost()
    {
        if (request()->class < 100) {
            return back()->with("error", "Vui lòng chọn môn phái!");
        }
        $user = Auth::user();
        if ($user->balance < 100000) {
            return back()->with("error", "Số dư xu trong tài khoản không đủ!");
        }
        $char = $user->main_id;
        $this->callGameApi("post", "/api/mail.php", [
            "receiver" => $char,
            "itemid"   => request()->class,
            "proctype" => 19,
            "count"    => 1,
        ]);
        $user->balance = intval($user->balance) - 100000;
        $user->save();
        return back()->with("success", "Yêu cầu thành công, vui lòng vào game nhận tại tín sứ!");
    }

    public function postEvent()
    {
        if (request()->class < 100) {
            return back()->with("error", "Vui lòng chọn môn phái!");
        }
        $user = Auth::user();
        if (Change::where("user_id", $user->id)->where("char_id", $user->main_id)->first()) {
            return back()->with("error", "Bạn đã đổi môn phái miễn phí 1 lần rồi, không thể đổi nữa!");
        }
        $change          = new Change();
        $change->user_id = $user->id;
        $change->char_id = $user->main_id;
        $change->class   = request()->class;
        $change->save();
        $char = $user->main_id;
        $this->callGameApi("post", "/api/mail.php", [
            "receiver" => $char,
            "itemid"   => request()->class,
            "count"    => 1,
            "proctype" => 19,
        ]);
        $name  = $user->char->name;
        $class = \App\Models\Char::CLASS_ITEM[request()->class] ?? "Chưa cập nhật";
        $msg   = "[{$name}] đã đăng ký đổi môn phái sang [{$class}] miễn phí thành công!";
        return back()->with("success", "Yêu cầu thành công, vui lòng vào game nhận tại tín sứ!");
    }

}
