<?php
namespace App\Http\Controllers;

use App\Models\AutoVip;
use App\Models\Bet;
use App\Models\Chat;
use App\Models\Deposit;
use App\Models\Task;
use App\Models\Faction;
use App\Models\Family;
use App\Models\FamilyUser;
use App\Models\Ip;
use App\Models\Kill;
use App\Models\Logging;
use App\Models\LotteryResult;
use App\Models\Promotion;
use App\Models\Sell;
use App\Models\SellItem;
use App\Models\ShopTrade;
use App\Models\Trade;
use App\Models\TradeItem;
use App\Models\User;
use App\Models\Vip;
use App\Models\Wheel;
use App\Services\CharService;
use App\Services\LoggingService;
use Carbon\Carbon;
use hrace009\PerfectWorldAPI\API;
use hrace009\PerfectWorldAPI\Gamed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    public function clear()
    {
        $kills = Kill::with(['char_kill', 'char_be_killed'])
            ->whereHas('char_kill', fn($q) => $q->where('vip', '<', 1))
            ->orWhereHas('char_be_killed', fn($q) => $q->where('vip', '<', 1))
            ->pluck("id");
        Kill::whereIn('id', $kills)->delete();
        return "success";
    }

    public function remove()
    {
        DB::table('kills')->where('kill', "<", 1)->delete();
        DB::table('pk_bosses')->where('kill', "<", 1)->delete();
    }

    public function ban()
    {
        try {
            $response = $this->callGameApi("get", "/api/online1.php", []);
            $data     = $response["data"];
            $trades   = [];
            return User::whereIn("userid", $data)->orderBy("name")->get()->pluck("name");
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }

    }

    public function ips()
    {
        try {
            $response = $this->callGameApi("get", "/api/ip.php", []);
            $data     = $response["data"];
            $trades   = [];
            foreach ($data as $trade) {
                $trades[] = [
                    "account" => $trade["user"],
                    "ip"      => $trade["ip"],
                ];
            }
            Ip::upsert(
                $trades,
                ['account', 'ip'],
                []
            );
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }

    }

    public function trades()
    {
        try {
            $response = $this->callGameApi("get", "/api/trades.php", []);
            $data     = $response["data"];
            $trades   = [];
            foreach ($data as $trade) {
                $params = [
                    "date"         => $trade["time"],
                    "from_char_id" => $trade["from"],
                    "to_char_id"   => $trade["to"],
                ];
                $item = Trade::where($params)->first();
                if (! $item) {
                    $newItemId = Trade::insertGetId($params);
                    foreach ($trade["items"] as &$m) {
                        $m["trade_id"] = $newItemId;
                    }
                    TradeItem::insert($trade["items"]);
                }
            }
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }

    }

    public function online()
    {
        try {
            $response = $this->callGameApi("get", "/api/online.php", []);
            return $response;
            $trades = [];
            foreach ($data as $trade) {
                $params = [
                    "date"         => $trade["time"],
                    "from_char_id" => $trade["from"],
                    "to_char_id"   => $trade["to"],
                ];
                $item = Trade::where($params)->first();
                if (! $item) {
                    $newItemId = Trade::insertGetId($params);
                    foreach ($trade["items"] as &$m) {
                        $m["trade_id"] = $newItemId;
                    }
                    TradeItem::insert($trade["items"]);
                }
            }
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }

    }

    public function sells()
    {
        try {
            $response = $this->callGameApi("get", "/api/sells.php", []);
            $data     = $response["data"];
            $trades   = [];
            foreach ($data as $trade) {
                $params = [
                    "date"         => $trade["timestamp"],
                    "from_char_id" => $trade["data"]["hrid"],
                    "to_char_id"   => $trade["data"][" huid"],
                ];
                $item = Sell::where($params)->first();
                if (! $item) {
                    $newItemId = Sell::insertGetId($params);
                    foreach ($trade["items"] as &$m) {
                        $m["sell_id"] = $newItemId;
                    }
                    SellItem::insert($trade["items"]);
                }
            }
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }

    }

    public function replaceSmile($msg)
    {
        $msg = trim($msg);
        $msg = str_replace(["", "", ""], "", $msg);
        return str_replace($this->smiles(), "*Biểu cảm* ", $msg);
    }

    public function tasks()
    {
        try {
            $response = $this->callGameApi("get", "/api/tasks.php", []);
            $data     = $response["data"];
            $trades   = [];
            foreach ($data as $trade) {
                $trades[] = [
                    "char_id" => $trade["char_id"],
                    "date" => $trade["date"],
                    "task_id" => $trade["task_id"]
                ];
            }
            Task::upsert(
                $trades,
                ['date', 'char_id'],
                ["task_id"]
            );
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }
    }

    public function jshop()
    {
        try {
            $response = $this->callGameApi("get", "/api/jshop.php", []);
            $data     = $response["data"];
            $trades   = [];
            foreach ($data as $trade) {
                $trades[] = [
                    "char_id" => $trade["char_id"],
                    "user_id"      => $trade["userid"],
                    "date" => $trade["time"],
                    "price" => $trade["price"],
                    "itemid" => $trade["itemid"],
                    "quantity" => $trade["quantity"],
                ];
            }
            ShopTrade::upsert(
                $trades,
                ['date', 'char_id'],
                ["user_id", "price", "itemid", "quantity"]
            );
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }
    }

    public function chats()
    {
        try {
            $response = $this->callGameApi("get", "/api/chat.php", []);
            $chat     = $response["data"];

            foreach ($chat as &$item) {

                if (in_array($item["channel"], ["Whisper", "Faction", "Party"]) && $item["type"] == "Family") {
                    $item["channel"] = "Family";
                }

                if (in_array($item["channel"], ["Whisper", "Trade", "Party"]) && $item["type"] == "Guild") {
                    $item["channel"] = "Faction";
                }
                $item["msg"] = $this->replaceSmile($item["msg"]);
            }

            $filtered = collect($chat)->filter(function ($value, int $key) {
                return true;
            });

            $chats = $filtered->values()->all();

            foreach ($chats as &$item) {
                switch ($item["type"]) {
                    case 'Chat':
                        if ($item["channel"] == "Party") {
                            $item["from"]  = "Tổ Đội";
                            $item["color"] = "#4ddd4d";
                        } elseif ($item["channel"] == "Common") {
                            $item["from"]  = "Lân Cận";
                            $item["color"] = "white";
                        } else {
                            $item["from"]  = "Thế Giới";
                            $item["color"] = "yellow";
                        }
                        break;
                    case 'Guild':
                        $item["from"]  = "Bang Hội";
                        $item["color"] = "cyan";
                        break;
                    case 'Whisper':
                        $item["from"]  = "Nói Thầm";
                        $item["color"] = "violet";
                        break;
                    case 'Family':
                        $item["from"]  = "Gia Tộc";
                        $item["color"] = "#2121c5";
                        break;
                    default:
                        $item["from"]  = "Thế Giới";
                        $item["color"] = "yellow";
                        break;
                }
            }

            Chat::upsert(
                $chats,
                ['uid', 'date'],
                ['type', 'channel', 'msg', 'from', 'color']
            );
            return "success";
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function loggings()
    {
    }

    public function updateVip()
    {
        try {
            $response = $this->callGameApi("get", "/api/vip.php", []);
            $data     = $response["data"];
            foreach ($data as $value) {
                $user = User::where("userid", $value["userid"])->first();
                if ($user) {
                    $user->viplevel = $value["viplevel"];
                    $user->save();
                }
            }
            return $data;
        } catch (\Throwable $th) {
            throw $th;
            return view("vip", ["vips" => []]);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $token = $request->header('Authorization');
        if (! $token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if (explode(" ", $token)[1] != env('AOC_API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        try {
            $code             = $request->code;
            $username         = strtolower(substr($code, 4));
            $user             = User::where("username", $username)->first();
            $amount           = $request->transferAmount;
            $amount_promotion = $amount;
            $processing_time  = $request->transactionDate;
            $bank             = $request->gateway;

            $trans                  = new Deposit;
            $trans->user_id         = $user->id ?? null;
            $trans->amount          = $amount;
            $trans->status          = "success";
            $trans->processing_time = $processing_time;

            $currentPromotion = $this->getCurrentPromotion();
            if ($currentPromotion) {
                if ($currentPromotion->type == "double") {
                    $amount_promotion = $amount_promotion * $currentPromotion->amount;
                } else {
                    $amount_promotion = $amount_promotion + $amount_promotion * $currentPromotion->amount / 100;
                }
            }
            $trans->amount_promotion = $amount_promotion;
            $user->balance           = $user->balance + $amount_promotion;
            $trans->save();
            $user->save();
            $msg = "Người chơi " . $username . " đã nạp " . number_format($amount) . "";
            //$this->sendMessage($msg);

            return response()->json("ok", 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getCurrentPromotion()
    {
        $now              = Carbon::now();
        $currentPromotion = Promotion::where('start_time', '<=', $now)->where('end_time', '>=', $now)->first();
        return $currentPromotion;
    }

    public function chars()
    {
        if (! isOnline()) {
            return response()->json(["status" => "server-offline"], 400);
        }

        (new CharService())->chars();
        return response()->json(["status" => "success"], 200);

    }

    public function guilds()
    {
        if (! isOnline()) {
            return response()->json(["status" => "server-offline"], 400);
        }
        $gamed    = new Gamed();
        $api      = new API();
        $handler  = null;
        $factions = [];
        $raw_info = $api->getRaw('faction', $handler);
        foreach ($raw_info['Raw'] as $i => $iValue) {
            $pack    = pack("H*", $iValue['value']);
            $faction = $gamed->unmarshal($pack, $api->data['FactionInfo']);
            array_push($factions, $faction);
        }
        $factions = array_filter($factions, function ($faction) {
            return isset($faction["fid"]) && $faction["fid"] > 0;
        });
        if (count($factions) == 0) {
            return false;
        }
        try {
            $response       = $this->callGameApi("get", "/api/guild.php", []);
            $data           = $response["data"];
            $faction_api    = $data["faction"];
            $family_api     = $data["family"];
            $familyuser_api = $data["familyuser"];
            $faction_clean  = [];
            foreach ($faction_api as $key => $faction) {
                array_push($faction_clean, [
                    "id"     => $faction["id"],
                    "name"   => "Bang Hội",
                    "level"  => $faction["level"],
                    "master" => $faction["master"],
                ]);
            }

            $guilds_res = [];
            foreach ($faction_clean as $key) {
                array_push($guilds_res, [
                    "id"        => $key["id"],
                    "name"      => $key["name"],
                    "level"     => intval($key["level"]) + 1,
                    "master_id" => $key["master"],
                ]);
            }
            Faction::upsert($guilds_res, ['id'], ["level", "master_id"]);
            $this->family($family_api);
            $this->familyuser($familyuser_api);
            return response()->json(["status" => "success"], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(["status" => "error"], 400);
        }
    }

    public function family($data)
    {
        $gamed    = new Gamed();
        $api      = new API();
        $handler  = null;
        $families = [];
        // $raw_info = $api->getRaw('family', $handler);
        // foreach ($raw_info['Raw'] as $i => $iValue) {
        //     $pack   = pack("H*", $iValue['value']);
        //     $family = $gamed->unmarshal($pack, $api->data['FactionInfo']);
        //     array_push($families, $family);
        // }
        // if (count($families) == 0) {
        //     return false;
        // }
        $family_clean = [];
        foreach ($data as $family) {
            array_push($family_clean, [
                "id"         => $family["id"],
                "name"       => "---",
                "faction_id" => $family["faction_id"],
                "master"     => $family["master"],
            ]);
        }

        $families_res = [];
        foreach ($family_clean as $key) {
            array_push($families_res, [
                "id"         => $key["id"],
                "name"       => $key["name"],
                "faction_id" => $key["faction_id"],
                "master_id"  => $key["master"],
            ]);
        }
        DB::table("families")->truncate();
        Family::insert($families_res);
        return $families_res;
    }

    public function familyuser($data)
    {
        $users_res = [];
        foreach ($data as $key) {
            array_push($users_res, [
                "char_id"   => $key["char_id"],
                "family_id" => $key["family_id"],
            ]);
        }
        if (count($data) == 0) {
            return false;
        }
        DB::table("family_users")->truncate();
        FamilyUser::insert($users_res);
        return $users_res;
    }

    public function refines()
    {
        $response = $this->callGameApi("get", "/api/refine.php", []);
        $data     = $response["data"];
        (new LoggingService())->refine_logs($data);
        return "success";
    }

    public function logins()
    {
        $response = $this->callGameApi("get", "/api/login.php", []);
        $data     = $response["data"];
        (new LoggingService())->login_logs($data);
        return "success";
    }

    public function boss()
    {
        $response = $this->callGameApi("get", "/api/boss.php", []);
        $data     = $response["data"];
        (new LoggingService())->boss_logs($data);
        return "success";
    }

    // public function lottery()
    // {
    //     $client   = new \GuzzleHttp\Client();
    //     $gameApi  = "https://xoso188.net/api/front/open/lottery/history/list/5/miba";
    //     $response = $client->request("GET", $gameApi, ["form_params" => []]);
    //     $response = json_decode($response->getBody()->getContents(), true);
    //     $today    = \Carbon\Carbon::now()->format("d/m/Y");
    //     $data     = $response["t"]["issueList"];
    //     $todayRes = ($data)[0];
    //     $result   = json_decode($todayRes["detail"]);

    //     $data = [
    //         "date" => $todayRes["turnNum"],
    //         "data" => [
    //             "1" => explode(",", $result[0]),
    //             "2" => explode(",", $result[1]),
    //             "3" => explode(",", $result[2]),
    //             "4" => explode(",", $result[3]),
    //             "5" => explode(",", $result[4]),
    //             "6" => explode(",", $result[5]),
    //             "7" => explode(",", $result[6]),
    //             "8" => explode(",", $result[7]),
    //         ],
    //     ];
    //     return $data;
    // }

    public function lottery()
    {
        $client   = new \GuzzleHttp\Client();
        $gameApi  = "https://xoso188.net/api/front/open/lottery/history/list/10/miba";
        $response = $client->request("GET", $gameApi, ["form_params" => []]);
        $response = json_decode($response->getBody()->getContents(), true);
        $today    = \Carbon\Carbon::now()->format("d/m/Y");
        $data     = $response["t"]["issueList"];

        $res = [];

        foreach ($data as $key) {
            $result  = json_decode($key["detail"]);
            $giai_db = $result[0];
            $res[]   = [
                "date"     => Carbon::createFromFormat('d/m/Y', $key["turnNum"]),
                "giai_db"  => $giai_db,
                "so_de"    => substr($giai_db, -2),
                "ba_cang"  => substr($giai_db, -3),
                "odd_even" => ((int) $giai_db % 2 === 0) ? 'odd' : 'even',
            ];
        }
        LotteryResult::upsert(
            $res,
            ['date'],
            ['giai_db', 'so_de', 'ba_cang', 'odd_even']
        );
        return $res;
    }

    private function getTaiXiu($result, $best)
    {
        $status = "lost";
        $type   = $best->odd_even;
        $so_de  = $result->so_de;
        $keps   = ["00", "11", "22", "33", "44", "55", "66", "77", "88", "99"];
        switch ($type) {
            case 'odd':
                if ($result->odd_even == "odd") {
                    $status = "won";
                }
                break;
            case 'even':
                if ($result->odd_even == "even") {
                    $status = "won";
                }
                break;
            case 'kep':
                if (in_array($so_de, $keps)) {
                    $status = "won";
                }
                break;
            case 'tai':
                if (intval($so_de) > 49) {
                    $status = "won";
                }
                break;
            case 'xiu':
                if (intval($so_de) < 50) {
                    $status = "won";
                }
                break;
            default:
                # code...
                break;
        }
        return $status;
    }

    public function bet()
    {
        $bets = Bet::whereStatus("pending")->get();
        foreach ($bets as $bet) {
            sleep(1);
            $result = LotteryResult::where("date", $bet->date)->first();
            if (! $result) {
                continue;
            }
            $type   = $bet->bet_type;
            $status = "lost";
            switch ($type) {
                case 'de':
                    if ($bet->number == $result->so_de) {
                        $status = "won";
                    }
                    break;
                case '3cang':
                    if ($bet->number == $result->ba_cang) {
                        $status = "won";
                    }
                    break;
                case 'odd_even':
                    $status = $this->getTaiXiu($result, $bet);
                    break;
                default:
                    # code...
                    break;
            }
            if ($status == "won") {
                $user = User::find($bet->user_id);
                if ($bet->coin_type == "knb") {
                    $user->balance = $user->balance + $bet->prize;
                } else {
                    $user->war_point = $user->war_point + $bet->prize;
                }
                $user->save();
                $this->sendWonMsg($bet, $user, $bet->prize, $bet->coin_type);
            }
            $bet->status = $status;
            $bet->save();
        }
        return $bets;
    }

    public function sendWonMsg($bet, $user, $prize, $coin_type)
    {
        $name   = $user->char ? $user->char->name : $user->username;
        $amount = number_format($prize);
        $type   = $coin_type == "knb" ? "xu nạp" : "xu war";

        $types = [
            'de'       => "Số đề",
            '3cang'    => "3 càng",
            'odd_even' => "Chẵn/Lẻ/Kép/Tài/Xỉu",
        ];

        $type2s = [
            'odd'  => "Chẵn",
            'tai'  => "Tài",
            'xiu'  => "Xỉu",
            'even' => "Lẻ",
            'kep'  => "Kép",
        ];
        $typex  = $types[$bet->bet_type];
        $chanle = $type2s[$bet->odd_even];
        $number = $bet->number;
        $date   = $bet->date;
        if ($bet->bet_type == "odd_even") {
            $msg = "[Chúc mừng] " . $name . " đã thắng cược {$amount} ({$type}) xổ số miền Bắc cho kèo [{$chanle}]";
        } else {
            $msg = "[Chúc mừng] " . $name . " đã thắng cược {$amount} ({$type}) xổ số miền Bắc cho kèo [{$typex}]: {$number}";
        }
        // sendMsg($msg, 1);
        // $chat          = new Chat;
        // $chat->date    = date("Y-m-d H:i:s");
        // $chat->type    = "Chat";
        // $chat->uid     = 1024;
        // $chat->channel = "World";
        // $chat->dest    = "1";
        // $chat->msg     = $msg;
        // $chat->from    = "Thế Giới";
        // $chat->color   = "yellow";
        // $chat->save();
    }

    public function war()
    {
        try {
            $response = $this->callGameApi("get", "/api/pk.php", []);
            $data     = $response["data"];
            (new LoggingService())->war($data);
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }
    }

    public function kill()
    {
        try {
            $response = $this->callGameApi("get", "/api/pkk.php", []);
            $data     = $response["data"];
            (new LoggingService())->kill($data);
            return "success";
        } catch (\Throwable $th) {
            return $th;
            return "error";
        }
    }

    public function autoVip()
    {
        $now  = Carbon::now();
        $vips = Vip::whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->get();
        $hongLoi5 = 52173;
        foreach ($vips as $vip) {
            $type = $vip->type;
            $msg  = $type == "week" ? "[Gói Đầu Tư Tuần] Hồng Lợi" : "[Gói Đầu Tư Tháng] Hồng Lợi";
            $this->callGameApi("post", "/api/mail.php", [
                "receiver" => $vip->user->main_id,
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

        }
        return "success";
    }

    public function trash()
    {
        $login_ids = Logging::where('type', 'login')
            ->whereDate('date', '<>', Carbon::today())
            ->pluck("id");
        Logging::whereIn('id', $login_ids)->delete();

        // $refine_ids = Logging::where('type', 'refine')
        //     ->whereDate('date', '<>', Carbon::today())
        //     ->pluck("id");
        // Logging::whereIn('id', $refine_ids)->delete();

        $chat_ids = Chat::whereDate('date', '<', Carbon::today()->subDays(1))
            ->pluck('id');
        Chat::whereIn('id', $chat_ids)->delete();
        return "success";
    }

}
