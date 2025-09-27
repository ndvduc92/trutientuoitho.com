<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Vip;
use Auth;

class TransactionController extends Controller
{
    public function transactions()
    {
        $shops = Transaction::where("user_id", Auth::user()->id)->where("type", "shop")->latest()->get();
        $vip = Transaction::where("user_id", Auth::user()->id)->where("type", "vip")->latest()->get();
        $knbs = Transaction::where("user_id", Auth::user()->id)->where("type", "knb")->latest()->get();
        $type = request()->type ?? "knb";
        return view("transactions", ["shops" => $shops, "knbs" => $knbs, "vip" => $vip, "type" => $type]);
    }

    public function vipHistory($id)
    {
        $items = Vip::find($id)->autos;
        return view("vip-history", compact("items"));
    }
}
