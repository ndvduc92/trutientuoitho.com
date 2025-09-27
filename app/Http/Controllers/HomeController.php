<?php
namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Kill;
use App\Models\Logging;
use App\Models\PkBoss;
use App\Models\Chat;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class HomeController extends Controller
{

    public function download()
    {
        return view("download");
    }

    public function pk()
    {


        $pks = Kill::with("char_kill", "char_be_killed")->where("kill", ">", 0)->orderByDesc("date")->limit(500)->get();

        $logs = collect($pks)->sortByDesc('date')->values()->all();
        return view('pk', ["pks" => $logs]);
    }
    
    public function class18()
    {
        return view("18class");
    }

    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function help()
    {
        return view("help");
    }

    public function auto()
    {
        return view("auto");
    }

    public function getMsg()
    {
        if (! request()->gm) {
            return redirect("/");
        }
        return view("msg");
    }

    public function postMsg()
    {
        sendMsg(request()->msg, request()->type);
        $chat          = new Chat;
        $chat->date    = date("Y-m-d H:i:s");
        $chat->type    = "Chat";
        $chat->uid     = 1024;
        $chat->channel = "World";
        $chat->dest    = "1";
        $chat->msg     = "[NPH]: " . request()->msg;
        $chat->from    = "Thế Giới";
        $chat->color   = "yellow";
        $chat->save();
        return back()->with("success", "Thành công!");
    }

    public function home()
    {
        return view('auth.profile');
    }
}
