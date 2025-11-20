<?php
namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Faction;
use App\Models\Guild;
use App\Models\PkBoss;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vip;
use App\Models\WarHistory;
use Auth;
use Carbon\Carbon;
use DB;
use hrace009\PerfectWorldAPI\API;
use Illuminate\Http\Request;

class WarController extends Controller
{

    public function index()
    {
        // $matchResults = [
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Seleha",
        //         "kill"  => 103,
        //         "die"   => 17,
        //         "kda"   => 86,
        //         "id"    => "1072",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Onimusha",
        //         "kill"  => 74,
        //         "die"   => 2,
        //         "kda"   => 72,
        //         "id"    => "3712",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Lies",
        //         "kill"  => 73,
        //         "die"   => 5,
        //         "kda"   => 68,
        //         "id"    => "1408",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "ChiPu",
        //         "kill"  => 60,
        //         "die"   => 17,
        //         "kda"   => 43,
        //         "id"    => "4304",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Zin",
        //         "kill"  => 45,
        //         "die"   => 5,
        //         "kda"   => 40,
        //         "id"    => "8784",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "v s A l l",
        //         "kill"  => 66,
        //         "die"   => 32,
        //         "kda"   => 34,
        //         "id"    => "1792",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "GộiĐầuMáy",
        //         "kill"  => 53,
        //         "die"   => 23,
        //         "kda"   => 30,
        //         "id"    => "4416",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Ủ a ạ l ô",
        //         "kill"  => 42,
        //         "die"   => 12,
        //         "kda"   => 30,
        //         "id"    => "10640",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "AntiAll",
        //         "kill"  => 31,
        //         "die"   => 9,
        //         "kda"   => 22,
        //         "id"    => "1712",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Oh Y e a h",
        //         "kill"  => 25,
        //         "die"   => 4,
        //         "kda"   => 21,
        //         "id"    => "9888",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Chà La Bốn",
        //         "kill"  => 26,
        //         "die"   => 9,
        //         "kda"   => 17,
        //         "id"    => "10864",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "NAT",
        //         "kill"  => 26,
        //         "die"   => 10,
        //         "kda"   => 16,
        //         "id"    => "10912",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Ngân98",
        //         "kill"  => 38,
        //         "die"   => 28,
        //         "kda"   => 10,
        //         "id"    => "1968",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Jim",
        //         "kill"  => 18,
        //         "die"   => 10,
        //         "kda"   => 8,
        //         "id"    => "1842",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "DịuYêuNước",
        //         "kill"  => 14,
        //         "die"   => 6,
        //         "kda"   => 8,
        //         "id"    => "8400",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Phong Nhi",
        //         "kill"  => 24,
        //         "die"   => 17,
        //         "kda"   => 7,
        //         "id"    => "11536",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Help Me",
        //         "kill"  => 38,
        //         "die"   => 33,
        //         "kda"   => 5,
        //         "id"    => "11552",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "River",
        //         "kill"  => 12,
        //         "die"   => 8,
        //         "kda"   => 4,
        //         "id"    => "4080",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "BộTrưởng",
        //         "kill"  => 8,
        //         "die"   => 6,
        //         "kda"   => 2,
        //         "id"    => "2560",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "HoàngLam",
        //         "kill"  => 10,
        //         "die"   => 9,
        //         "kda"   => 1,
        //         "id"    => "9152",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "S l o w",
        //         "kill"  => 1,
        //         "die"   => 0,
        //         "kda"   => 1,
        //         "id"    => "11824",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Ta",
        //         "kill"  => 3,
        //         "die"   => 4,
        //         "kda"   => -1,
        //         "id"    => "5714",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Bengi",
        //         "kill"  => 0,
        //         "die"   => 1,
        //         "kda"   => -1,
        //         "id"    => "1456",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Mistique",
        //         "kill"  => 8,
        //         "die"   => 9,
        //         "kda"   => -1,
        //         "id"    => "1808",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "DâmNữ",
        //         "kill"  => 3,
        //         "die"   => 5,
        //         "kda"   => -2,
        //         "id"    => "5762",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "GPU-Z",
        //         "kill"  => 0,
        //         "die"   => 2,
        //         "kda"   => -2,
        //         "id"    => "9440",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Kokomi",
        //         "kill"  => 0,
        //         "die"   => 2,
        //         "kda"   => -2,
        //         "id"    => "11696",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Nhà Quê",
        //         "kill"  => 28,
        //         "die"   => 30,
        //         "kda"   => -2,
        //         "id"    => "16512",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Đắc Đạo",
        //         "kill"  => 1,
        //         "die"   => 4,
        //         "kda"   => -3,
        //         "id"    => "1616",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Min",
        //         "kill"  => 0,
        //         "die"   => 3,
        //         "kda"   => -3,
        //         "id"    => "7136",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Master",
        //         "kill"  => 0,
        //         "die"   => 3,
        //         "kda"   => -3,
        //         "id"    => "9744",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Peos",
        //         "kill"  => 1,
        //         "die"   => 4,
        //         "kda"   => -3,
        //         "id"    => "12112",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "HaLpie",
        //         "kill"  => 0,
        //         "die"   => 4,
        //         "kda"   => -4,
        //         "id"    => "1152",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Giảo",
        //         "kill"  => 0,
        //         "die"   => 4,
        //         "kda"   => -4,
        //         "id"    => "12704",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "M E O",
        //         "kill"  => 0,
        //         "die"   => 4,
        //         "kda"   => -4,
        //         "id"    => "3728",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "TieuDao",
        //         "kill"  => 0,
        //         "die"   => 5,
        //         "kda"   => -5,
        //         "id"    => "12656",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "s2gi0s2",
        //         "kill"  => 0,
        //         "die"   => 5,
        //         "kda"   => -5,
        //         "id"    => "1168",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "SonCa",
        //         "kill"  => 0,
        //         "die"   => 5,
        //         "kda"   => -5,
        //         "id"    => "2256",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "AEON",
        //         "kill"  => 0,
        //         "die"   => 6,
        //         "kda"   => -6,
        //         "id"    => "5888",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Độc",
        //         "kill"  => 0,
        //         "die"   => 6,
        //         "kda"   => -6,
        //         "id"    => "13328",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Thân Nam",
        //         "kill"  => 0,
        //         "die"   => 6,
        //         "kda"   => -6,
        //         "id"    => "18416",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Tai",
        //         "kill"  => 9,
        //         "die"   => 17,
        //         "kda"   => -8,
        //         "id"    => "8496",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Kazumi",
        //         "kill"  => 1,
        //         "die"   => 9,
        //         "kda"   => -8,
        //         "id"    => "1472",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "100",
        //         "kill"  => 9,
        //         "die"   => 17,
        //         "kda"   => -8,
        //         "id"    => "1137",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Pikachu",
        //         "kill"  => 5,
        //         "die"   => 14,
        //         "kda"   => -9,
        //         "id"    => "9344",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Liu",
        //         "kill"  => 7,
        //         "die"   => 16,
        //         "kda"   => -9,
        //         "id"    => "12480",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Hit",
        //         "kill"  => 9,
        //         "die"   => 19,
        //         "kda"   => -10,
        //         "id"    => "1488",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "2uckyb0y",
        //         "kill"  => 3,
        //         "die"   => 17,
        //         "kda"   => -14,
        //         "id"    => "1120",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "Faker",
        //         "kill"  => 2,
        //         "die"   => 17,
        //         "kda"   => -15,
        //         "id"    => "13344",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "SAKURA",
        //         "kill"  => 2,
        //         "die"   => 18,
        //         "kda"   => -16,
        //         "id"    => "13360",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Lặng",
        //         "kill"  => 3,
        //         "die"   => 21,
        //         "kda"   => -18,
        //         "id"    => "5344",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Com Quê",
        //         "kill"  => 16,
        //         "die"   => 35,
        //         "kda"   => -19,
        //         "id"    => "1824",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "BolyDon",
        //         "kill"  => 2,
        //         "die"   => 22,
        //         "kda"   => -20,
        //         "id"    => "4576",
        //     ],
        //     [
        //         "guild" => "BigBang",
        //         "name"  => "ZUKI",
        //         "kill"  => 7,
        //         "die"   => 28,
        //         "kda"   => -21,
        //         "id"    => "5616",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "LongCa",
        //         "kill"  => 9,
        //         "die"   => 30,
        //         "kda"   => -21,
        //         "id"    => "2176",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "AOE",
        //         "kill"  => 26,
        //         "die"   => 51,
        //         "kda"   => -25,
        //         "id"    => "8016",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "MunM eo",
        //         "kill"  => 11,
        //         "die"   => 39,
        //         "kda"   => -28,
        //         "id"    => "1248",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "Quá Đẹp",
        //         "kill"  => 6,
        //         "die"   => 38,
        //         "kda"   => -32,
        //         "id"    => "1200",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "PC Tutien",
        //         "kill"  => 1,
        //         "die"   => 37,
        //         "kda"   => -36,
        //         "id"    => "9456",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "QuyDe",
        //         "kill"  => 1,
        //         "die"   => 51,
        //         "kda"   => -50,
        //         "id"    => "7904",
        //     ],
        //     [
        //         "guild" => "Galaxy",
        //         "name"  => "MengCò",
        //         "kill"  => 13,
        //         "die"   => 63,
        //         "kda"   => -50,
        //         "id"    => "1440",
        //     ],
        // ];

        // foreach ($matchResults as $player) {
        //     $aa = new WarHistory;
        //     $aa->date = date("Y-m-d");
        //     $aa->char_id = $player['id'];
        //     $aa->kill = $player['kill'];
        //     $aa->be_killed = $player['die'];
        //     $aa->save();
        // }

        $guildKills = [];

        $hoachugam = "13347";
        $sachvip   = "84902";

        // $gameApi = "http://202.92.6.133";
        // $client  = new \GuzzleHttp\Client();

        // foreach ($matchResults as $player) {
        //     $guild = $player['guild'];
        //     if ($guild == "BigBang") {

        //         $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //             "receiver" => $player['id'],
        //             "itemid"   => $sachvip,
        //             "count"    => 4,
        //             "proctype" => 19,
        //             "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //         ]]);
        //         $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //             "receiver" => $player['id'],
        //             "itemid"   => $hoachugam,
        //             "count"    => 210,
        //             "proctype" => 19,
        //             "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //         ]]);
        //         $char          = Char::where("char_id", $player['id'])->first();
        //         $user_id       = $char->user->id;
        //         $user          = User::find($user_id);
        //         $user->balance = $user->balance + 200000;
        //         $user->war_point = $user->war_point + 500;
        //         $user->save();
        //     } else {
        //         $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //             "receiver" => $player['id'],
        //             "itemid"   => $sachvip,
        //             "count"    => 2,
        //             "proctype" => 19,
        //             "msg"      => "[NPH] Quà Tặng Thua Trận",
        //         ]]);
        //         $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //             "receiver" => $player['id'],
        //             "itemid"   => $hoachugam,
        //             "count"    => 121,
        //             "proctype" => 19,
        //             "msg"      => "[NPH] Quà Tặng Thua Trận",
        //         ]]);
        //         $char          = Char::where("char_id", $player['id'])->first();
        //         $user_id       = $char->user->id;
        //         $user          = User::find($user_id);
        //         $user->balance = $user->balance + 100000;
        //         $user->war_point = $user->war_point + 300;
        //         $user->save();
        //     }

        // }

        // return $guildKills;
        $date = PkBoss::latest()->first()->date;
        $date = Carbon::parse($date)->format("Y-m-d");
        $type = request()->type ?? "date";
        $data = [];
        if ($type == "date") {
            $data = $this->wars($date);
        } else {
            $data = Char::whereNot("war_kill", 0)->whereNot("war_be_killed", 0)->orderByRaw('war_kill - war_be_killed DESC')->get();

        }
        return view("war", [
            "chars" => $data,
            "date"  => $date,
        ]);
    }

    private function list($date = null)
    {
        if ($date) {
            $date = Carbon::parse($date)->format("Y-m-d");

            // Lấy tất cả char_id xuất hiện trong kill hoặc be_killed theo ngày
            $kills      = PkBoss::whereDate('date', '=', $date)->pluck('kill')->toArray();
            $be_killeds = PkBoss::whereDate('date', '=', $date)->pluck('be_killed')->toArray();
        } else {
            // Nếu không có date -> lấy toàn bộ dữ liệu
            $kills      = PkBoss::pluck('kill')->toArray();
            $be_killeds = PkBoss::pluck('be_killed')->toArray();
        }

        // Gộp lại và lọc unique
        $charIds = array_unique(array_merge($kills, $be_killeds));

        // Lấy thông tin nhân vật
        $chars = Char::with('user')
            ->whereIn('char_id', $charIds)
            ->get()
            ->map(function ($char) {
                return [
                    'char_id'    => $char->char_id,
                    'name'       => $char->name,
                    'class_icon' => $char->class_icon,
                    'class_name' => $char->class_name,
                    'user_id'    => $char->user->id ?? null,
                ];
            })
            ->values()
            ->all();

        return $chars;
    }

    public function getTodayCharWarIds()
    {
        // 1. Định nghĩa ngày hôm nay để lọc
        $today = Carbon::today()->toDateString();

        // 2. Truy vấn chỉ số Mạng hạ gục (Kills)
        // Lọc theo cột 'date' của bạn (có chứa timestamp)
        $killsData = PkBoss::whereDate('date', $today)
            ->groupBy('kill')
            ->select('kill as char_id', DB::raw('count(*) as total_kills'))
            ->get()
            ->keyBy('char_id'); // Key collection bằng char_id để dễ dàng tra cứu

        // 3. Truy vấn chỉ số Bị hạ gục (Deaths)
        $deathsData = PkBoss::whereDate('date', $today)
            ->groupBy('be_killed')
            ->select('be_killed as char_id', DB::raw('count(*) as total_deaths'))
            ->get()
            ->keyBy('char_id'); // Key collection bằng char_id để dễ dàng tra cứu

        // 4. Hợp nhất tất cả các ID nhân vật tham gia
        $allCharIds = collect($killsData->keys())
            ->merge($deathsData->keys())
            ->unique()
            ->values();

        // 5. Xây dựng mảng kết quả cuối cùng
        $results = $allCharIds->map(function ($charId) use ($killsData, $deathsData) {

            // Tra cứu số liệu từ collections đã được keyBy
            $kills  = $killsData->get($charId)['total_kills'] ?? 0;
            $deaths = $deathsData->get($charId)['total_deaths'] ?? 0;

            return [
                'char_id'       => (int) $charId, // Ép kiểu về số nguyên
                'war_kill'      => $kills,
                'war_be_killed' => $deaths,
                'kda_diff'      => $kills - $deaths, // Hiệu số Kills - Deaths
            ];
        });

        // 6. Sắp xếp kết quả: Ưu tiên Kills (Giảm dần), sau đó là Deaths (Tăng dần)
        $sortedResults = $results->sortBy([
            ['war_kill', 'desc'],
            ['war_be_killed', 'asc'],
        ])->values()->all();

        return $sortedResults;
    }

    public function top3()
    {
        $tops    = ["4416", "5714", "8784", "1808", "19424", "8016"];
        $gameApi = "http://202.92.6.133";
        $client  = new \GuzzleHttp\Client();
        foreach ($tops as $char) {
            $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
                "receiver" => $char,
                "itemid"   => "84902",
                "count"    => 5,
                "proctype" => 19,
                "msg"      => "[NPH] Quà Tặng Top 3",
            ]]);
            $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
                "receiver" => $char,
                "itemid"   => "81330",
                "count"    => 10000,
                "proctype" => 19,
                "msg"      => "[NPH] Quà Tặng Top 3",
            ]]);
        }
        return 1;
    }

    public function reward()
    {
        return view("reward");
    }

    public function postReward(Request $request)
    {
        $win        = (int) $request->input('win');        // 1 hoặc 2
        $win_point  = (int) $request->input('win_point');  // ví dụ: 1500
        $lose_point = (int) $request->input('lose_point'); // ví dụ: 1200
        $top        = $request->input('top');              // text, có thể dùng cho log
        $support    = $request->input('support');          // text, có thể dùng cho log

        $bigbang = 3;
        $dragon  = 4;

        $date      = PkBoss::latest()->first();
        $data      = $this->list($date->date);
        $winnerMem = Faction::find(3)->getAllMember();
        $loserMem  = Faction::find(4)->getAllMember();

        $grouped = [
            'winner' => [],
            'loser'  => [],
        ];
        foreach ($data as $char) {
            $charId = (int) $char['char_id'];
            if (in_array($charId, $winnerMem)) {
                $grouped['winner'][] = $char;
            }

            if (in_array($charId, $loserMem)) {
                $grouped['loser'][] = $char;
            }

        }

        return $grouped;

        //$exs = ["5762", ];

        // $top = [[
        //     "char_id" => 4576
        // ]];

        // ID vật phẩm phần thưởng
        $hoachugam = "13347";
        $sachvip   = "84902";
        $cuutieu   = "75245";
        $camtinh   = "56001";
        $camnang   = "84154";
        $tithu     = "84139";

        $gameApi = "http://202.92.6.133";
        $client  = new \GuzzleHttp\Client();

        // --- HÀM PHỤ: gửi quà ---
        $sendReward = function ($player, $items, $money, $points) use ($client, $gameApi) {
            foreach ($items as $item) {
                $client->request('POST', $gameApi . '/api/mail.php', [
                    "form_params" => [
                        "receiver" => $player['char_id'],
                        "itemid"   => $item['id'],
                        "count"    => $item['count'],
                        "proctype" => 19,
                        "msg"      => "[NPH] Quà Tặng Bang Chiến",
                    ],
                ]);
            }

            // Cập nhật tài khoản người chơi
            $char = Char::where("char_id", $player['char_id'])->first();
            if ($char && $char->user) {
                $user = $char->user;
                $user->balance += $money;
                $user->war_point += $points;
                $user->save();
            }
        };

        // --- Phần thưởng phe thắng ---
        $winItems = [
            ['id' => $cuutieu, 'count' => 1],
            ['id' => $camtinh, 'count' => 1],
            ['id' => $camnang, 'count' => 1],
            ['id' => $tithu, 'count' => 1],
            ['id' => $sachvip, 'count' => 4],
            ['id' => $hoachugam, 'count' => 200],
            ['id' => '77092', 'count' => 5],
            ['id' => '77093', 'count' => 5],
            ['id' => '78999', 'count' => 5]
        ];

        // --- Phần thưởng phe thua ---
        $loseItems = [
            ['id' => $cuutieu, 'count' => 1],
            ['id' => $camtinh, 'count' => 1],
            ['id' => $camnang, 'count' => 1],
            ['id' => $tithu, 'count' => 1],
            ['id' => $sachvip, 'count' => 3],
            ['id' => $hoachugam, 'count' => 150],
            ['id' => '77092', 'count' => 5],
            ['id' => '77093', 'count' => 5],
            ['id' => '78999', 'count' => 5]
        ];

        // $top = [1504, 8784];

        // foreach ($top as $player) {
        //     $sendReward($player, $winItems, 100000, 500);
        // }

        // return 1;

        // Gửi thưởng
        foreach ($grouped["winner"] as $player) {
            $sendReward($player, $winItems, 100000, 500);
        }
        foreach ($grouped["loser"] as $player) {
            $sendReward($player, $loseItems, 75000, 400);
        }

        return back()->with('success', 'Phát thưởng thành công!');
    }

    public function live()
    {
        //return 1;
        //return $this->top3();
        $date = PkBoss::latest()->first();
        //$data = $this->getTodayCharWarIds();
        $data       = $this->wars($date->date);
        $galaxy     = 4;
        $bigbang    = 3;
        $galaxyMem  = Faction::find($galaxy)->getAllMember();
        $bigbangMem = Faction::find($bigbang)->getAllMember();

        $grouped = [
            'galaxy'  => [],
            'bigbang' => [],
        ];
        foreach ($data as $char) {
            $charId = (int) $char['char_id'];

            if (in_array($charId, $galaxyMem)) {
                $grouped['galaxy'][] = $char;
            }

            if (in_array($charId, $bigbangMem)) {
                $grouped['bigbang'][] = $char;
            }
        }

        // $hoachugam = "13347";
        // $sachvip   = "84902";
        // $cuutieu   = "75245";
        // $camtinh   = "56001";
        // $camnang   = "84154";
        // $tithu     = "84139";

        // $gameApi = "http://202.92.6.133";
        // $client  = new \GuzzleHttp\Client();
        // return 1;
        // $aa = [1472];
        // foreach ($aa as $player) {

        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player,
        //         "itemid"   => $cuutieu,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player,
        //         "itemid"   => $camtinh,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player,
        //         "itemid"   => $camnang,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player,
        //         "itemid"   => $tithu,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);

        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player,
        //         "itemid"   => $sachvip,
        //         "count"    => 10,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player,
        //         "itemid"   => $hoachugam,
        //         "count"    => 500,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $char            = Char::where("char_id", $player)->first();
        //     $user_id         = $char->user->id;
        //     $user            = User::find($user_id);
        //     $user->balance   = $user->balance + 600000;
        //     $user->war_point = $user->war_point + 1500;
        //     $user->save();

        // }

        // return "done";

        // foreach ($grouped["bigbang"] as $player) {
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $cuutieu,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $camtinh,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $camnang,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $tithu,
        //         "count"    => 3,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);

        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $sachvip,
        //         "count"    => 10,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $hoachugam,
        //         "count"    => 500,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $char            = Char::where("char_id", $player['char_id'])->first();
        //     $user_id         = $char->user->id;
        //     $user            = User::find($user_id);
        //     $user->balance   = $user->balance + 600000;
        //     $user->war_point = $user->war_point + 1500;
        //     $user->save();

        // }

        // foreach ($grouped["galaxy"] as $player) {

        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $cuutieu,
        //         "count"    => 2,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $camtinh,
        //         "count"    => 2,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $camnang,
        //         "count"    => 2,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $tithu,
        //         "count"    => 2,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);

        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $sachvip,
        //         "count"    => 7,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $client->request('POST', $gameApi . '/api/mail.php', ["form_params" => [
        //         "receiver" => $player['char_id'],
        //         "itemid"   => $hoachugam,
        //         "count"    => 400,
        //         "proctype" => 19,
        //         "msg"      => "[NPH] Quà Tặng Thắng Trận",
        //     ]]);
        //     $char            = Char::where("char_id", $player['char_id'])->first();
        //     $user_id         = $char->user->id;
        //     $user            = User::find($user_id);
        //     $user->balance   = $user->balance + 500000;
        //     $user->war_point = $user->war_point + 1200;
        //     $user->save();

        // }
        // return 1;
        return view("war-live", [
            "data" => $grouped,
            "date" => Carbon::now()->format("Y/m/d"),
        ]);
    }

    private function wars($date = null)
    {

        //$kill      = PkBoss::groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
        //$be_killed = PkBoss::groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();

        if ($date) {
            $kill      = PkBoss::whereDate('date', '=', Carbon::parse($date)->format("Y-m-d"))->groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
            $be_killed = PkBoss::whereDate('date', '=', Carbon::parse($date)->format("Y-m-d"))->groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();
        }

        $result1 = array_map(function ($val) {
            return $val['kill'];
        }, (array) $kill->toArray());

        $result2 = array_map(function ($val) {
            return $val['be_killed'];
        }, (array) $be_killed->toArray());

        $chars = array_values(array_unique(array_merge($result1 + $result2)));

        $res = [];

        $names = Char::with("user")->whereIn("char_id", $chars)->get();

        foreach ($chars as $char) {
            $kills      = collect($kill)->firstWhere('kill', $char);
            $be_killeds = collect($be_killed)->firstWhere('be_killed', $char);
            $char       = [
                "char_id"       => $char,
                "class_icon"    => collect($names)->firstWhere('char_id', $char)["class_icon"],
                "class_name"    => collect($names)->firstWhere('char_id', $char)["class_name"],
                "user_id"       => collect($names)->firstWhere('char_id', $char)["user"]["id"],
                "name"          => collect($names)->firstWhere('char_id', $char)["name"],
                "war_kill"      => $kills ? $kills["total"] : 0,
                "war_be_killed" => $be_killeds ? $be_killeds["total"] : 0,
                "res"           => ($kills ? $kills["total"] : 0) - ($be_killeds ? $be_killeds["total"] : 0),
            ];
            $res[] = $char;
        }

        $sorted = collect($res)->sortBy([
            ['war_kill', 'desc'],
            ['war_be_killed', 'asc'],
        ]);

        $res = $sorted->values()->all();

        return $res;
    }

    public function shopHistory()
    {
        $shops = Transaction::where("type", "shop")->latest()->get();
        return view('histories', ["shops" => $shops]);
    }

    public function getWarKnb()
    {
        return view("war-knb");
    }

    public function postWarKnb()
    {
        if (! isOnline()) {
            return back()->with("error", "Server chưa hoạt động. Vui lòng quay lại sau.");
        }
        $ratio = 2;
        $user  = Auth::user();

        $war_point      = $user->war_point;
        $war_point_used = $user->war_point_used;
        $remain         = $war_point - $war_point_used;
        $xu             = request()->cash;
        if ($xu < 50 || $remain < $xu) {
            return back()->with("error", "Số điểm quy đổi phải lớn hơn 50 và nhỏ hơn số điểm chiến tích hiện có!");
        }

        $now = Carbon::now();

        $lastRecord = Vip::where("user_id", Auth::user()->id)->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return back()->with("error", "Thao tác quá nhanh, quay lại sau vài phút nữa nhé!!!");
            }

        }

        $lastRecord = Transaction::where("user_id", Auth::user()->id)->where("type", "knb")->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return back()->with("error", "Thao tác quá nhanh, quay lại sau 2 phút nữa nhé!!!");
            }

        }

        $lastRecord = Transaction::where("user_id", Auth::user()->id)->where("type", "war_knb")->latest()->first();

        if ($lastRecord) {
            $totalDuration = $now->diffInSeconds($lastRecord->created_at);
            if ($totalDuration < 120) {
                return back()->with("error", "Thao tác quá nhanh, quay lại sau 2 phút nữa nhé!!!");
            }

        }
        try {
            DB::beginTransaction();
            $this->callGameApi("POST", "/api/knb.php", [
                "userid" => $user->userid,
                "cash"   => intval($xu * 100) * $ratio,
            ]);
            $user->war_point_used = intval($user->war_point_used) + $xu;
            $user->save();

            $transaction             = new Transaction;
            $transaction->user_id    = $user->id;
            $transaction->knb_amount = $xu * 2;
            $transaction->type       = "war_knb";
            $transaction->save();
            return back()->with("success", "Đã chuyển " . intval($xu) * $ratio . " KNB vào game thành công!");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }

    public function warHistory()
    {

        $knbs = Transaction::with("guild", "guild.item")->where("type", "war")->latest()->paginate(50);
        return view("war-history", ["knbs" => $knbs]);
    }

    public function getShop()
    {
        $shops = Guild::where("status", "active")->get();
        return view("wars.shop", ["shops" => $shops]);
    }

    public function postShop(Request $request)
    {
        if (! isOnline()) {
            return redirect()->back()->with('error', 'Hãy quay lại khi server hoạt động.');
        }
        $user = Auth::user();
        if ($user->main_id == "") {
            return redirect()->back()->with('error', 'Chưa chọn nhân vật để mua vật phẩm.');
        }

        if ($request->quantity < 1) {
            return redirect()->back()->with('error', 'Số lượng không thể nhỏ hơn 1.');
        }

        $shop = Guild::find($request->shop_id);
        if ($request->quantity > $shop->stack) {
            return redirect()->back()->with('error', 'Số lượng không thể lớn hơn số lượng xếp chồng của vật phẩm.');
        }
        $war_point      = $user->war_point;
        $war_point_used = $user->war_point_used;
        $remain         = $war_point - $war_point_used;
        $cash           = $request->quantity * $shop->price;
        if ($remain < $cash) {
            return redirect()->back()->with('error', 'Số xu war không đủ.');
        }
        try {
            DB::beginTransaction();
            $this->callGameApi("post", "/api/mail.php", [
                "receiver" => $user->main_id,
                "itemid"   => $shop->itemid,
                "count"    => $request->quantity,
                "msg"      => "[Shop Xu War] " . $shop->item->name . " x" . $request->quantity,
                "proctype" => $shop->bind,
            ]);
            $user->war_point_used = $war_point_used + $cash;
            $user->save();

            $transaction                = new Transaction;
            $transaction->user_id       = $user->id;
            $transaction->shop_quantity = $request->quantity;
            $transaction->shop_id       = $request->shop_id;
            $transaction->type          = "war";
            $transaction->char_id       = $user->main_id;
            $transaction->save();
            //if ($shop->broadcast == 1) {
            $api  = new API;
            $name = Auth::user()->char->name;
            $item = $shop->item->name;
            $num  = $request->quantity;
            //$msg = "[{$name}]: đã mua [{$item}] x{$num} từ Shop Bang Chiến.";
            //sendMsg($msg);
            DB::commit();
            return back()->with('success', 'Chúc mừng bạn đã mua thành công ' . $request->quantity . ' cái ' . $shop->item->name . ' với ' . $cash . ' xu war');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with("error", "Có lỗi xảy ra, vui lòng liên hệ GM!");
        }
    }
}
