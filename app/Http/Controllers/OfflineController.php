<?php
namespace App\Http\Controllers;

use App\Models\CharItem;
use App\Models\OfflineSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfflineController extends Controller
{
    public function index()
    {
        $session = OfflineSession::where("char_id", current_user()->main_id)->where("status", "active")->first();
        $total = OfflineSession::where("status", "active")->count();
        return view("offline", ["session" => $session, "total" => $total]);
    }


    public function cronjob()
    {
        $session = OfflineSession::where("status", "active")->get();
        foreach ($session as $s) {
            if (!isRoleOnline($s->char_id)) {
                continue; // Skip if the character is offline
            }
            $drops = $this->calculateDrops($s);
            foreach ($drops as $drop) {
                $exist = CharItem::where("itemid", $drop['item_id'])
                    ->where("char_id", $s->char_id)
                    ->first();
                if (! $exist) {
                    $newItem           = new CharItem();
                    $newItem->user_id  = $s->user_id;
                    $newItem->char_id  = $s->char_id;
                    $newItem->itemid   = $drop['item_id'];
                    $newItem->quantity = $drop['quantity'];
                    $newItem->save();
                } else {
                    $exist->quantity += $drop['quantity'];
                    $exist->save();
                }
            }
            $s->status   = 'completed';
            $s->end_time = now();
            $s->save();
        }
        return response()->json(['status' => 'success', 'message' => 'Treo máy đã được xử lý thành công!']);
    }

    public function post(Request $request)
    {
        if (current_user()->balance < 100000) {
            return back()->with('error', 'Duy trì số xu ít nhất 100.000 mới được sử dụng tính năng này!');
        }
        $session = OfflineSession::where("char_id", current_user()->main_id)->where("status", "active")->first();
        if ($session) {
            $charId = current_user()->main_id;
            $drops  = $this->calculateDrops($session);

            foreach ($drops as $drop) {
                $exist = CharItem::where("itemid", $drop['item_id'])
                    ->where("char_id", current_user()->main_id)
                    ->first();
                if (! $exist) {
                    $newItem           = new CharItem();
                    $newItem->user_id  = current_user()->id;
                    $newItem->char_id  = current_user()->main_id;
                    $newItem->itemid   = $drop['item_id'];
                    $newItem->quantity = $drop['quantity'];
                    $newItem->save();
                } else {
                    $exist->quantity += $drop['quantity'];
                    $exist->save();
                }
            }

            $session->status   = 'completed';
            $session->end_time = now();
            $session->save();
            return redirect("/inventory")->with('success', 'Ngừng treo máy thành công, kiểm tra túi đồ nhé!');
        }
        if (isYouOnline()) {
            return back()->with('error', 'Bạn không thể treo máy khi đang online trong game!');
        }
        $session             = new OfflineSession;
        $session->char_id    = current_user()->main_id;
        $session->status     = 'active';
        $session->start_time = now();
        $session->save();
        $msg = current_user()->char->name . ' đã bắt đầu treo máy offline lúc ' . now()->format('H:i:s') . '.';
        sendMsg($msg);
        return back()->with('success', 'Phiên treo máy đã được khởi tạo thành công!');
    }

    private function calculateDrops($session)
    {
        $startTime = Carbon::parse($session->start_time);
        $endTime   = Carbon::now();
        $minutes   = $startTime->diffInMinutes($endTime);

        $drops = [];

        foreach (OfflineSession::DROP_RATES as $rate) {
            $expectedDrops = $rate['drop_rate_per_minute'] * $minutes;

            $totalQuantity = 0;

            for ($i = 0; $i < floor($expectedDrops); $i++) {
                $quantity = rand($rate['min_quantity'], $rate['max_quantity']);
                $totalQuantity += $quantity;
            }

            if (($expectedDrops - floor($expectedDrops)) > 0) {
                if (mt_rand() / mt_getrandmax() < ($expectedDrops - floor($expectedDrops))) {
                    $quantity = rand($rate['min_quantity'], $rate['max_quantity']);
                    $totalQuantity += $quantity;
                }
            }

            if ($totalQuantity > 0) {
                $drops[] = [
                    'item_id'   => $rate['item_id'],
                    'item_name' => $rate['item_name'],
                    'quantity'  => $totalQuantity,
                ];
            }
        }

        return $drops;
    }

}
