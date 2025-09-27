<?php
namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\LotteryResult;
use Auth;
use Carbon\Carbon;
use hrace009\PerfectWorldAPI\API;
use hrace009\PerfectWorldAPI\Gamed;

class GameController extends Controller
{

    public function index()
    {
        $data = LotteryResult::latest()->limit(10)->get();
        $bets = Bet::where("user_id", current_user()->id)->latest()->get();
        return view("games.index", compact("data", "bets"));
    }

    private function lottery()
    {
        $client   = new \GuzzleHttp\Client();
        $gameApi  = "https://xoso188.net/api/front/open/lottery/history/list/10/miba";
        $response = $client->request("GET", $gameApi, ["form_params" => []]);
        $response = json_decode($response->getBody()->getContents(), true);
        $today    = \Carbon\Carbon::now()->format("d/m/Y");
        $data     = $response["t"]["issueList"];

        $res = [];
        foreach ($data as $key) {
            $result = json_decode($key["detail"]);

            $res[] = [
                "date" => $key["turnNum"],
                "data" => $result[0],
            ];
        }

        return $res;
    }

    private function prize($request)
    {
        $rate     = 1;
        $bet_type = $request->bet_type;
        $rates    = [
            'odd'  => 2,
            'even' => 2,
            'kep'  => 10,
            'tai'  => 2,
            'xiu'  => 2,
        ];
        switch ($bet_type) {
            case 'de':
                $rate = 95;
                break;
            case '3cang':
                $rate = 500;
                break;
            case 'odd_even':
                $rate = $rates[$request->odd_even];
                break;
            default:
                # code...
                break;
        }
        return $request->amount * $rate;
    }

    public function post()
    {
        $now      = time();
        $deadline = strtotime(date('Y-m-d') . ' 18:00:00'); // mốc 18h hôm nay

        if ($now >= $deadline) {
            return back()->with("error", "🚫 Đã quá 18h00. Vui lòng quay lại vào ngày mai để đặt cược.");
        }
        $rates = [
            'de'       => 95,
            '3cang'    => 500,
            'odd_even' => 2,
        ];
        $bet_type = request()->bet_type;
        if ($bet_type == "de") {
            request()->validate([
                'number' => [
                    'regex:/^\d{2}$/',
                ],
            ], [
                'number.regex' => 'Số đề phải gồm đúng 2 chữ số từ 00 đến 99.',
            ]);
        }
        if ($bet_type == "3cang") {
            request()->validate([
                'number' => ['required', 'regex:/^\d{3}$/'],
            ], [
                'number.regex' => 'Số 3 càng phải gồm đúng 3 chữ số từ 000 đến 999.',
            ]);
        }
        $coin_type = request()->coin_type;
        if ($coin_type == "knb") {
            if (current_user()->balance < request()->amount) {
                return back()->with("error", "Số dư xu nạp không đủ để đặt cược!");
            }
        } else {
            if (current_user()->warCoin() < request()->amount) {
                return back()->with("error", "Số dư xu war không đủ để đặt cược!");
            }
        }

        $bet            = new Bet;
        $bet->user_id   = current_user()->id;
        $bet->bet_type  = request()->bet_type;
        $bet->number    = request()->number;
        $bet->odd_even  = request()->odd_even;
        $bet->coin_type = request()->coin_type;
        $bet->date      = Carbon::now();
        $bet->amount    = request()->amount;
        $bet->status    = "pending";
        $bet->prize     = $this->prize(request());
        $bet->save();
        $user = Auth::user();
        if ($coin_type == "knb") {
            $user->balance = $user->balance - request()->amount;
        } else {
            $user->war_point_used = $user->war_point_used + request()->amount;
        }
        $user->save();
        $name  = current_user()->char->name;
        $xu    = request()->amount;
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
        $type   = $types[request()->bet_type];
        $chanle = $type2s[request()->odd_even];
        $number = request()->number;
        $msg    = "";
        if (request()->bet_type == "odd_even") {
            $msg = "[{$name}] đã đặt cược {$xu} (xu nạp) sổ xố miền Bắc cho kèo [{$type}]: {$chanle}";
        } else {
            $msg = "[{$name}] đã đặt cược {$xu} (xu nạp) sổ xố miền Bắc cho kèo [{$type}]: {$number}";
        }
        sendMsg($msg);
        return back()->with("success", "Đã đặt cược thành công.");
    }

    public function getOnlineList()
    {
        $gamed = new Gamed();
        $api   = new API();
        return $api->getOnlineList();
    }
    /**
     * Display a listing of the resource.
     */
    public function isOnline($roleId)
    {
        $api = new API();
        return $api->checkRoleOnline($roleId);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function worldChat($role, $msg, $channel)
    {
        $api = new API();
        return $api->worldChat($role, $msg, $channel);
    }
}
