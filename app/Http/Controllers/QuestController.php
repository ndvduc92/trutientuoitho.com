<?php
namespace App\Http\Controllers;

use App\Models\CharItem;
use App\Models\Chat;
use App\Models\Deposit;
use App\Models\Task;
use App\Models\Kill;
use App\Models\Logging;
use App\Models\PkBoss;
use App\Models\Quest;
use App\Models\QuestUser;
use App\Models\ShopTrade;
use App\Models\Trade;
use App\Models\Wheel;
use Auth;
use Carbon\Carbon;

class QuestController extends Controller
{

    public function get()
    {
        $items = Quest::find(3)->items()->get();

        $quests = Quest::with("items", "users")->where("status", "active")->get();
        return view("quests.index", ["quests" => $quests]);
    }

    public function post($id)
    {

        $quest     = Quest::with("items")->findOrFail($id);
        $questUser = QuestUser::where("user_id", current_user()->id)
            ->where("char_id", current_user()->main_id)
            ->where("quest_id", $quest->id)
            ->whereDate('date', Carbon::today())
            ->first();
        if (! $questUser) {

            $code = $quest->code;
            $msg  = "Không đủ điều kiện hoàn thành nhiệm vụ này!";
            switch ($code) {
                case "diem_danh":
                    $this->diem_danh($quest->id);
                    break;
                case "tai_loc":
                    if (! $this->tai_loc($quest->id)) {
                        return back()->withErrors(["Tiến hành rung cây tài lộc ở bên phía menu bên trái"]);
                    }
                    break;
                case "pk":
                    if (! $this->pk($quest->id)) {
                        return back()->withErrors(["Phải kích sát ít nhất 1 người chơi khác không phải là noob"]);
                    }
                    break;
                case "war":
                    if (! $this->war($quest->id)) {
                        return back()->withErrors(["Phải đạt ít nhất 1 kill hoặc die trong sự kiện bang chiến"]);
                    }
                    break;
                case "kill_boss":
                    if (! $this->kill_boss($quest->id)) {
                        return back()->withErrors(["Vui lòng vào game tiêu diệt 1 con boss bất kỳ"]);
                    }
                    break;
                case "login":
                    if (! $this->login($quest->id)) {
                        return back()->withErrors(["Bạn phải đăng nhập vào game trong ngày để hoàn thành nhiệm vụ này"]);
                    }
                    break;
                case "deposit":
                    if (! $this->deposit($quest->id)) {
                        return back()->withErrors(["Tiến hành nạp tiền mệnh giá ít nhất 50,000đ"]);
                    }
                    break;
                case "refine":
                    if (! $this->refine($quest->id)) {
                        return back()->withErrors(["Tiến hành tinh luyện một trang bị bất kỳ lên cấp 12"]);
                    }
                    break;
                case "pha-hung-chu":
                    if (! $this->phc($quest->id)) {
                        return back()->withErrors(["Vui lòng vào game và hoàn thành Nhiệm Vụ"]);
                    }
                    break;
                case "te-yeu-phong":
                    if (! $this->typ($quest->id)) {
                        return back()->withErrors(["Vui lòng vào game và hoàn thành Nhiệm Vụ"]);
                    }
                    break;
                case "hac-tiet-truc":
                    if (! $this->htt($quest->id)) {
                        return back()->withErrors(["Vui lòng vào game và hoàn thành Nhiệm Vụ"]);
                    }
                    break;
                case "chat":
                    if (! $this->chat($quest->id)) {
                        return back()->withErrors(["Vui lòng vào game chat 1 câu bất kỳ trên kênh thế giới"]);
                    }
                    break;
                case "trade":
                    if (! $this->trade($quest->id)) {
                        return back()->withErrors(["Vui lòng phát sinh giao dịch ít nhất 1 lần"]);
                    }
                    break;
                case "guild":
                    if (! $this->guild($quest->id)) {
                        return back()->withErrors(["Gia nhập Bang Hội lớn hơn cấp 4"]);
                    }
                    break;
                case "be_killed":
                    if (! $this->be_killed($quest->id)) {
                        return back()->withErrors(["Bị người khác giết ít nhất 1 lần"]);
                    }
                    break;
                case "jshop":
                    if (! $this->jshop($quest->id)) {
                        return back()->withErrors(["Mua vật phẩm ở shop J ít nhất 10 KNB"]);
                    }
                    break;
                default:
                    return back()->withErrors(["Mã nhiệm vụ không hợp lệ!"]);
            }
            $this->saveToInventory($quest->items);
            return back()->with("success", "Bạn đã làm nhiệm vụ này thành công!");
        } else {
            return back()->withErrors(["Bạn đã làm nhiệm vụ này rồi!"]);
        }
    }

    private function saveToInventory($items)
    {
        foreach ($items as $item) {
            $exist = CharItem::where("itemid", $item->itemid)
                ->where("char_id", current_user()->main_id)
                ->first();
            if (! $exist) {
                $newItem           = new CharItem();
                $newItem->user_id  = current_user()->id;
                $newItem->char_id  = current_user()->main_id;
                $newItem->itemid   = $item->itemid;
                $newItem->quantity = $item->quantity;
                $newItem->save();
            } else {
                $exist->quantity += $item->quantity;
                $exist->save();
            }
        }
    }

    private function diem_danh($quest_id)
    {
        return $this->logging($quest_id, "diem_danh");
    }

    private function tai_loc($quest_id)
    {
        $wheel     = Wheel::where("type", "daily")->first();
        $freeTimes = $wheel->usedTimes("free");
        if ($freeTimes == 0) {
            return false;
        }
        return $this->logging($quest_id, "tai_loc");
    }

    private function guild($quest_id)
    {

        $level = current_user()->char->guildLevel();
        if ($level < 4) {
            return false;
        }
        return $this->logging($quest_id, "guild");
    }

    private function pk($quest_id)
    {
        $kills = Kill::where('kill', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->count();
        if ($kills < 1) {
            return false;
        }
        return $this->logging($quest_id, "pk");
    }

    private function be_killed($quest_id)
    {
        $kills = Kill::where('be_killed', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->count();
        if ($kills < 1) {
            return false;
        }
        return $this->logging($quest_id, "be_killed");
    }

    private function war($quest_id)
    {
        $kills = PkBoss::where('kill', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->count();
        $bekills = PkBoss::where('be_killed', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->count();
        if (($kills + $bekills) == 0) {
            return false;
        }
        return $this->logging($quest_id, "war");
    }

    private function trade($quest_id)
    {
        $kills = Trade::where('from_char_id', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->count();
        $bekills = Trade::where('to_char_id', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->count();
        if (($kills + $bekills) == 0) {
            return false;
        }
        return $this->logging($quest_id, "trade");
    }

    private function jshop($quest_id)
    {
        $kills = ShopTrade::where('char_id', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->where("price", ">=", 2000)
            ->count();
        if (($kills) == 0) {
            return false;
        }
        return $this->logging($quest_id, "jshop");
    }

    private function phc($quest_id)
    {
        $kills = Task::where('char_id', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->where("task_id", 60084)
            ->count();
        if (($kills) == 0) {
            return false;
        }
        return $this->logging($quest_id, "pha-hung-chu");
    }

    private function typ($quest_id)
    {
        $kills = Task::where('char_id', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->where("task_id", 60082)
            ->count();
        if (($kills) == 0) {
            return false;
        }
        return $this->logging($quest_id, "te-yeu-phong");
    }

    private function htt($quest_id)
    {
        $kills = Task::where('char_id', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->where("task_id", 60083)
            ->count();
        if (($kills) == 0) {
            return false;
        }
        return $this->logging($quest_id, "hac-tiet-truc");
    }

    private function kill_boss($quest_id)
    {
        $boss = Logging::where('char_id', current_user()->main_id)
            ->where("type", "boss")
            ->whereDate('date', Carbon::today())
            ->exists();
        if (! $boss) {
            return false;
        }
        return $this->logging($quest_id, "kill_boss");
    }

    private function login($quest_id)
    {
        if (isYouOnline()) {
            return $this->logging($quest_id, "login");
        }
        $login = Logging::where('char_id', current_user()->main_id)
            ->where("type", "login")
            ->whereDate('date', Carbon::today())
            ->exists();
        if (! $login) {
            return false;
        }
        return $this->logging($quest_id, "login");
    }

    private function deposit($quest_id)
    {
        $hasDepositToday = Deposit::where('user_id', current_user()->id)
            ->where("amount", ">=", 100000)
            ->whereDate('created_at', Carbon::today())
            ->exists();
        if (! $hasDepositToday) {
            return false;
        }
        return $this->logging($quest_id, "deposit");
    }

    private function refine($quest_id)
    {
        $hasRefine = Logging::where('char_id', current_user()->main_id)
            ->where("type", "refine")
            ->where("refine_level_after", ">", 11)
            ->whereDate('date', Carbon::today())
            ->exists();
        if (! $hasRefine) {
            return false;
        }
        return $this->logging($quest_id, "refine");
    }

    private function chat($quest_id)
    {
        $hasChat = Chat::where('uid', current_user()->main_id)
            ->whereDate('date', Carbon::today())
            ->exists();
        if (! $hasChat) {
            return false;
        }
        return $this->logging($quest_id, "chat");
    }

    private function logging($quest_id, $code)
    {
        $questUser           = new QuestUser();
        $questUser->user_id  = current_user()->id;
        $questUser->char_id  = current_user()->main_id;
        $questUser->quest_id = $quest_id;
        $questUser->code     = $code;
        $questUser->date     = Carbon::now();
        $questUser->save();

        $quest          = Quest::find($quest_id);
        $user           = Auth::user();
        $user->xu_event = $user->xu_event + $quest->xu;
        $user->save();
        $msg = "[" . current_user()->char->name . "] đã hoàn thành nhiệm vụ [" . $quest->name . "] tại website";
        sendMsg($msg);

        return true;
    }
}
