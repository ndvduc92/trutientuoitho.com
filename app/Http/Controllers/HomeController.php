<?php

namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Kill;
use App\Models\Post;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home()
    {
        $date = "2025/01/09";
        $last = [];
        $pk = [];
        $posts = Post::latest()->limit(5)->get();
        //$pk = Char::whereNot("kill", 0)->orderBy("kill", "desc")->limit(50)->get();
        return view('home', compact("posts", "pk", "last", "date"));
    }

    private function lastWars()
    {
        return Kill::latest()->first();
    }

    private function wars($date = null)
    {

        $kill = Kill::groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
        $be_killed = Kill::groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();

        if ($date) {
            $kill = Kill::whereDate('date', '=', Carbon::parse($date)->format("Y/m/d"))->groupBy('kill')->select('kill', DB::raw('count(*) as total'))->orderBy("total", "DESC")->get();
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
            $kills = collect($kill)->firstWhere('kill', $char);
            $be_killeds = collect($be_killed)->firstWhere('be_killed', $char);
            $char = [
                "char_id" => $char,
                "class_icon" => collect($names)->firstWhere('char_id', $char)["class_icon"],
                "class_name" => collect($names)->firstWhere('char_id', $char)["class_name"],
                "user_id" => collect($names)->firstWhere('char_id', $char)["user"]["id"],
                "name" => collect($names)->firstWhere('char_id', $char)["name"],
                "kill" => $kills ? $kills["total"] : 0,
                "be_killed" => $be_killeds ? $be_killeds["total"] : 0,
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

    public function news()
    {
        $posts = Post::latest()->paginate(10);
        if (request()->q) {
            $posts = Post::where("title", "LIKE", "%" . request()->q . "%")->latest()->paginate(10);
        }
        return view('news', compact("posts"));
    }

    public function new ($slug)
    {
        $post = Post::where("slug", $slug)->first();
        return view('new', compact("post"));
    }

    public function download()
    {
        return view('download');
    }

    public function library()
    {
        return view('library');
    }

    public function event()
    {
        return view('event');
    }

    public function wiki()
    {
        return view('wiki');
    }

    public function chiso()
    {
        return view('wiki.chisothangthien');
    }
}
