<?php
use hrace009\PerfectWorldAPI\API;

function ceil_to_1000($number)
{
    return number_format(ceil($number / 1000) * 1000);
}

function getAcc($userid)
{
    $user     = \App\Models\User::where("userid", $userid)->first();
    $username = $user->username ?? "";
    if ($username == "") {
        return "";
    }
    return substr($username, 0, 3) . "******";
}

function sendMsg($msg, $type = 9)
{
    $api = new API();
    $api->worldChat(16, $msg, $type);
}

if (! function_exists('current_user')) {
    function current_user()
    {
        return Auth::user();
    }
}

function getChar($userid)
{
    $user     = \App\Models\User::where("userid", $userid)->first();
    $username = $user->username ?? "";
    if ($username) {
        return $user->getMain();
    } else {
        return "Chưa tạo nhân vật";
    }
}

function getName($char)
{
    $char = \App\Models\Char::where("char_id", $char)->first();
    return $char ? $char->getName() : "Chưa cập nhật";
}

function getNv($char)
{
    $char = \App\Models\Char::where("char_id", $char)->first();
    return $char ?? null;
}

function timeAgo($time_ago)
{
    $time_ago     = strtotime($time_ago);
    $cur_time     = \Carbon\Carbon::now()->timestamp;
    $time_elapsed = $cur_time - $time_ago;
    $seconds      = $time_elapsed;
    $minutes      = round($time_elapsed / 60);
    $hours        = round($time_elapsed / 3600);
    $days         = round($time_elapsed / 86400);
    $weeks        = round($time_elapsed / 604800);
    $months       = round($time_elapsed / 2600640);
    $years        = round($time_elapsed / 31207680);
    // Seconds
    $showDate = false;
    if ($seconds <= 60) {
        $msg = "$seconds " . 'giây trước';
    }
    //Minutes
    elseif ($minutes <= 60) {
        $msg = "$minutes " . 'phút trước';
    }
    //Hours
    elseif ($hours <= 24) {
        $msg = "$hours " . 'giờ trước';
    }
    //Days
    elseif ($days <= 7) {
        if ($days == 1) {
            $msg = 'Hôm qua';
        } else {
            $showDate = true;
            $msg      = "$days " . 'ngày trước';
        }
    }
    //Weeks
    elseif ($weeks <= 4.3) {
        $showDate = true;
        $msg      = "$weeks " . 'tuần trước';
    }
    //Months
    elseif ($months <= 12) {
        $showDate = true;
        $msg      = "$months " . 'tháng trước';
    }
    //Years
    else {
        $showDate = true;
        $msg      = "$years " . 'năm trước';
    }

    return [
        "showDate" => $showDate,
        "time"     => $msg,
    ];
}

function gameApi($method, $path, $params = null)
{
    $client   = new \GuzzleHttp\Client();
    $gameApi  = env('GAME_API_ENDPOINT', 'http://103.56.160.134');
    $response = $client->request($method, $gameApi . $path, ["form_params" => $params]);
    $response = json_decode($response->getBody()->getContents(), true);
    return $response;
}

function isOnline()
{
    $api = new API;
    return $api->online;
}

function isYouOnline()
{
    if (! Auth::user()->main_id) {
        return false;
    }

    return checkRoleOnline(intval(Auth::user()->main_id));
}

function roleOnline($id)
{
    try {
        return checkRoleOnline(intval($id));
    } catch (\Throwable $th) {
        return false;
    }

}

function isRoleOnline($id)
{
    $api = new API;
    try {
        return checkRoleOnline(intval($id));
    } catch (\Throwable $th) {
        return false;
    }

}

function checkRoleOnline($id)
{
    $result      = false;
    $totalOnline = getOnlineList();

    foreach ($totalOnline as $online) {
        if (intval($online) == intval($id)) {
            $result = true;
        }
    }
    return $result;

}

function totalOnline()
{
    $count = gameApi("GET", "/api/online.php", [])["online"];
    if ($count == 0) {
        return 0;
    }

    if ($count > 400) {
        return $count + 200;
    }
    return $count + 50;
}

function getOnlineList()
{
    if (! isOnline()) {
        return [];
    }

    try {
        $ids = gameApi("GET", "/api/online1.php", [])["data"];
        $ids = array_map(function ($id) {
            return intval($id);
        }, $ids);
        $charIds = \App\Models\User::whereNotNull("main_id")->whereIn("userid", $ids)->pluck("main_id");
        return $charIds;
    } catch (\Throwable $th) {
        return [];
    }

}

function getItem($itemid)
{
    $item = \App\Models\Item::where("itemid", $itemid)->first();
    return $item ? $item->name : "Chưa cập nhật";
}

function randomOnline()
{
    try {
        return [];
        $ids = gameApi("GET", "/api/onlines.php", [])["data"];
        $ids = array_map(function ($id) {
            return intval($id);
        }, $ids);
        $charIds = \App\Models\User::whereNotNull("main_id")->whereIn("userid", $ids)->pluck("main_id");
        $chars   = \App\Models\Char::whereNotIn("char_id", \App\Models\Char::GMS)->whereIn("char_id", $charIds)->inRandomOrder()->limit(10)->get();
        return $chars;
    } catch (\Throwable $th) {
        return [];
    }
}

function getRandomStringRandomInt($length = 32)
{
    $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pieces      = [];
    $max         = mb_strlen($stringSpace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $stringSpace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function meta()
{
    $main  = \App\Models\Meta::where("user_id", Auth::user()->id)->pluck("meta_user_id")->toArray();
    $metas = [];
    if (count($main)) {
        $metas = $main;
    } else {
        $main1 = \App\Models\Meta::where("meta_user_id", Auth::user()->id)->first();
        if ($main1) {
            $main2 = \App\Models\Meta::where("user_id", $main1->user_id)->pluck("meta_user_id")->toArray();
            $metas = $main2;
            array_push($metas, $main1->user_id);
        }
    }
    array_push($metas, Auth::user()->id);
    return \App\Models\User::whereIn("id", $metas)->orderBy("userid")->get();
}

function isMainMeta($id)
{
    return \App\Models\Meta::where("user_id", $id)->first();
}

function dateFormat($date)
{
    return \Carbon\Carbon::parse($date)->format("d/m/Y");
}

if (! function_exists('getImageSlot')) {
    function getImageSlot(array $equipment, int $slotPos): ?string
    {
        foreach ($equipment as $item) {
            if ($item['pos'] === $slotPos) {
                return $item['image'] ?? null;
            }
        }
        return null;
    }
}
