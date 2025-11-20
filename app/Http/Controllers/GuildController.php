<?php

namespace App\Http\Controllers;

use App\Models\Faction;
use App\Models\Family;
use App\Models\FamilyUser;
use App\Models\User;
use Auth;

class GuildController extends Controller
{
    public function getGuild()
    {
        $familyUser = FamilyUser::where("char_id", Auth::user()->main_id)->first();
        $guild = null;
        $guild_id = $familyUser?->family?->faction?->id;
        if ($guild_id) {
            $guild = Faction::with("families", "families.chars")->find($guild_id);
        }
        return view("guild", ["guild" => $guild]);
    }
}
