<?php
namespace App\Services;

use App\Models\Char;
use App\Models\Kill;
use App\Models\Logging;
use App\Models\PkBoss;
use DB;

class LoggingService
{
    public function __construct()
    {
        if (! isOnline()) {
            return false;
        }
    }

    public function refine_logs($data)
    {
        $refines = [];
        foreach ($data as $value) {
            array_push($refines, [
                "type"                => "refine",
                "itemid"              => $value['itemid'],
                "refine_stoneid"      => $value["stone"],
                "date"                => $value["time"],
                "char_id"             => $value["player"],
                "refine_level_before" => $value["level_before"],
                "refine_level_after"  => $value["level_after"],
            ]);
        }
        Logging::upsert(
            $refines,
            ['type', 'date', 'char_id'],
            ['refine_level_before', "refine_level_after", "refine_stoneid", "itemid"]
        );
    }

    public function login_logs($data)
    {
        $refines = [];
        foreach ($data as $value) {
            array_push($refines, [
                "type"    => "login",
                "value"   => rtrim(explode("role", $value["type"])[1], ","),
                "date"    => $value["time"],
                "char_id" => $value["player"],
            ]);
        }
        Logging::upsert(
            $refines,
            ['char_id', 'type', 'date'],
            ['value']
        );
    }

    public function boss_logs($data)
    {
        $refines = [];
        foreach ($data as $value) {
            array_push($refines, [
                "type"    => "boss",
                "date"    => $value["time"],
                "bossid"  => $value["bossid"],
                "char_id" => $value["player"],
            ]);
        }
        Logging::upsert(
            $refines,
            ['char_id', 'type', 'date'],
            ['bossid']
        );
    }

    public function trade()
    {

    }

    public function war($data)
    {
        $refines = [];
        foreach ($data as $value) {
            array_push($refines, [
                "date"      => $value["time"],
                "kill"      => $value["kill"],
                "be_killed" => $value["be_killed"],
            ]);
        }
        PkBoss::upsert(
            $refines,
            ['date', 'kill', 'be_killed'], []
        );
        $kills = PkBoss::with(['char_kill', 'char_be_killed'])
            ->whereHas('char_kill', fn($q) => $q->where('vip', '<', 1))
            ->orWhereHas('char_be_killed', fn($q) => $q->where('vip', '<', 1))
            ->pluck("id");
        PkBoss::whereIn('id', $kills)->delete();
        $kill      = PkBoss::groupBy('kill')->select('kill', DB::raw('count(*) as total'))->get();
        $be_killed = PkBoss::groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();
        foreach ($kill as $value) {
            $char = Char::where("char_id", $value->kill)->first();
            if ($char) {
                $char->war_kill = $value["total"];
                $char->save();
            }

        }

        foreach ($be_killed as $value) {
            $char = Char::where("char_id", $value->be_killed)->first();
            if ($char) {
                $char->war_be_killed = $value["total"];
                $char->save();
            }
        }
    }

    public function kill($data)
    {
        $refines = [];
        foreach ($data as $value) {
            array_push($refines, [
                "date"      => $value["time"],
                "kill"      => $value["kill"],
                "be_killed" => $value["be_killed"],
            ]);
        }
        Kill::upsert(
            $refines,
            ['date', 'kill', 'be_killed'], []
        );

        $this->clear();
        $kill      = Kill::groupBy('kill')->select('kill', DB::raw('count(*) as total'))->get();
        $be_killed = Kill::groupBy('be_killed')->select('be_killed', DB::raw('count(*) as total'))->get();
        foreach ($kill as $value) {
            $char = Char::where("char_id", $value->kill)->first();
            if ($char) {
                $char->kill = $value["total"];
                $char->save();
            }

        }

        foreach ($be_killed as $value) {
            $char = Char::where("char_id", $value->be_killed)->first();
            if ($char) {
                $char->be_killed = $value["total"];
                $char->save();
            }
        }
    }

    public function clear()
    {
        $kills = Kill::with(['char_kill', 'char_be_killed'])
            ->whereHas('char_kill', fn($q) => $q->where('vip', '<', 1))
            ->orWhereHas('char_be_killed', fn($q) => $q->where('vip', '<', 1))
            ->pluck("id");
        Kill::whereIn('id', $kills)->delete();
        return "success";
    }
}
