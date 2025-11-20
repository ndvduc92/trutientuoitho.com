<?php
namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Kill;
use DB;

class RankController extends Controller
{
    public function rank()
    {
        $type = request()->get("type", "pk");
        $data = [];
        switch ($type) {
            case 'pk':

                $data = Char::where('kill', '!=', 0)
                    ->select('*')
                    ->addSelect(DB::raw('(`kill` - `be_killed`) as score'))
                    ->orderByRaw('`kill` - `be_killed` DESC')
                    ->get();

                break;
            case 'war':

                $data = Char::where('war_kill', '!=', 0)
                    ->where('war_be_killed', '!=', 0)
                    ->select('*')
                    ->addSelect(DB::raw('(`war_kill` - `war_be_killed`) as war_score'))
                    ->orderByRaw('war_score DESC')
                    ->get();

                break;
            case 'boss':
                $data = Char::withCount('bosses')
                    ->having('bosses_count', '>', 0)
                    ->orderByDesc('bosses_count')
                    ->get();
                break;
            case 'online':
                $data = Char::where("time_used", ">", 3600)->whereNot("vip", 0)->orderBy("time_used", "desc")->get();
                break;
            default:
                # code...
                break;
        }
        return view('rank', ["chars" => $data]);
    }

    private function wars($date = null)
    {

        $kill      = Kill::groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
        $be_killed = Kill::groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();

        if ($date) {
            $kill      = Kill::whereDate('date', '=', Carbon::parse($date)->format("Y/m/d"))->groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
            $be_killed = Kill::whereDate('date', '=', Carbon::parse($date)->format("Y/m/d"))->groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();
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
                "char_id"    => $char,
                "class_icon" => collect($names)->firstWhere('char_id', $char)["class_icon"],
                "class_name" => collect($names)->firstWhere('char_id', $char)["class_name"],
                "user_id"    => collect($names)->firstWhere('char_id', $char)["user"]["id"],
                "name"       => collect($names)->firstWhere('char_id', $char)["name"],
                "kill"       => $kills ? $kills["total"] : 0,
                "be_killed"  => $be_killeds ? $be_killeds["total"] : 0,
            ];
            $res[] = $char;
        }

        $sorted = collect($res)->sortBy([
            ['kill', 'desc'],
            ['be_killed', 'asc'],
        ]);

        $res = $sorted->values()->all();

        return $res;
    }
}
