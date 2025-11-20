<?php
namespace App\Http\Controllers;

use App\Models\Logging;

class IngameController extends Controller
{

    public function index()
    {
        $bosses = Logging::with("char")->where("type", "boss")->orderByDesc("date")->limit(200)->get();
        foreach ($bosses as $key => $value) {
            $value["category"] = "boss";

            if ($value["type"] == "boss" && ! in_array(($value["bossid"]), array_keys(Logging::BOSSES))) {
                unset($bosses[$key]);
            }
        }
        return view('ingame', compact("bosses"));
    }
}
