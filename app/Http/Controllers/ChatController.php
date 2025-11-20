<?php
namespace App\Http\Controllers;

use App\Models\Char;
use App\Models\Chat;
use App\Models\Faction;
use App\Models\Family;
use App\Models\FamilyUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use hrace009\PerfectWorldAPI\API;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function replaceSmile($msg)
    {
        $msg = trim($msg);
        $msg = str_replace(["", "", ""], "", $msg);
        return str_replace($this->smiles(), "*Biểu cảm* ", $msg);
    }

    public function chatsxx()
    {
        if (current_user()->viplevel > 5) {
            return $this->vipChat();
        }
        $smiles = $this->smiles();
        try {

            $response = $this->callGameApi("get", "/api/chat.php", []);
            $chat     = $response["data"];

            $filtered = collect($chat)->filter(function ($value, int $key) {
                return $value["channel"] == "World" && in_array($value["type"], ["Chat", "World"]);
            });

            $chats = $filtered->values()->all();

            foreach ($chats as &$item) {
                $item["from"]  = "Thế Giới";
                $item["color"] = "yellow";
                $item["msg"]   = $this->replaceSmile($item["msg"]);
            }
        } catch (\Throwable $th) {
            $chats = [];
        }

        $chat     = [];
        $chs      = [];
        $names    = [];
        $char_ids = Char::select("id", "char_id", "name", "vip")->whereIn("char_id", (array) collect($chats)->pluck("uid")->values()->all())->get();

        foreach ($char_ids as $id) {
            array_push($names, [
                "char_id" => $id["char_id"],
                "vip"     => $id["vip"],
                "name"    => $id["name"],
            ]);
        }
        foreach (array_reverse($chats) as $key => $ch) {
            $found = collect($names)->firstWhere('char_id', $ch["uid"]);
            if ($found) {
                $ch["name"] = $found["name"];
                $ch["vip"]  = $found["vip"];
                array_push($chs, $ch);
            }
        }

        $chats  = Chat::with("char")->where("from", "Thế Giới")->limit(500)->latest()->get()->toArray();
        $all    = array_merge($chats, $chs);
        $sorted = collect($all)->sortByDesc('date');

        $res = $sorted->values()->all();
        $res = collect($res)->unique(function ($item) {
            return $item['uid'] . '-' . $item['date'];
        });
        return view("chats", ["chs" => $res]);

    }

    public function vipChat()
    {
        try {

            $response = $this->callGameApi("get", "/api/chat.php", []);
            $chat     = $response["data"];

            foreach ($chat as &$item) {

                if (in_array($item["channel"], ["Whisper", "Faction", "Party"]) && $item["type"] == "Family") {
                    $item["channel"] = "Family";
                }

                if (in_array($item["channel"], ["Whisper", "Trade", "Party"]) && $item["type"] == "Guild") {
                    $item["channel"] = "Faction";
                }
                $item["msg"] = $this->replaceSmile($item["msg"]);
            }

            $filtered = collect($chat)->filter(function ($value, int $key) {
                return true;
            });

            $chats = $filtered->values()->all();

            foreach ($chats as &$item) {
                switch ($item["type"]) {
                    case 'Chat':
                        if ($item["channel"] == "Party") {
                            $item["from"]  = "Tổ Đội";
                            $item["color"] = "#4ddd4d";
                        } elseif ($item["channel"] == "Common") {
                            $item["from"]  = "Lân Cận";
                            $item["color"] = "white";
                        } else {
                            $item["from"]  = "Thế Giới";
                            $item["color"] = "yellow";
                        }
                        break;
                    case 'Guild':
                        $item["from"]  = "Bang Hội";
                        $item["color"] = "cyan";
                        break;
                    case 'Whisper':
                        $item["from"]  = "Nói Thầm";
                        $item["color"] = "violet";
                        break;
                    case 'Family':
                        $item["from"]  = "Gia Tộc";
                        $item["color"] = "#2121c5";
                        break;
                    default:
                        $item["from"]  = "Thế Giới";
                        $item["color"] = "yellow";
                        break;
                }
            }
        } catch (\Throwable $th) {
            $chats = [];
        }
        $chat     = [];
        $chs      = [];
        $names    = [];
        $char_ids = Char::select("id", "char_id", "name", "vip")->whereIn("char_id", (array) collect($chats)->pluck("uid")->values()->all())->get();
        foreach ($char_ids as $id) {
            array_push($names, [
                "char_id" => $id->char_id,
                "name"    => $id->name,
                "vip"     => $id["vip"],
            ]);
        }

        foreach (array_reverse($chats) as $key => $ch) {
            $found = collect($names)->firstWhere('char_id', $ch["uid"]);
            if ($found) {
                $ch["name"]      = $found["name"];
                $ch["vip"]       = $found["vip"];
                $ch["dest_name"] = collect($names)->firstWhere('char_id', $ch["dest"]) ? collect($names)->firstWhere('char_id', $ch["dest"])["name"] : "";
                array_push($chs, $ch);
            }
        }
        $chats  = Chat::with("char")->where("from", "Thế Giới")->limit(500)->latest()->get()->toArray();
        $all    = array_merge($chats, $chs);
        $sorted = collect($all)->sortByDesc('date');

        $res = $sorted->values()->all();
        $res = collect($res)->unique(function ($item) {
            return $item['uid'] . '-' . $item['date'];
        });
        $char_id = Auth::user()->main_id;

        $familyUser   = FamilyUser::where("char_id", Auth::user()->main_id)->first();
        $familyUsers  = [];
        $factionUsers = [];
        $family_id    = $familyUser?->family?->id;
        if ($family_id) {
            $family      = Family::with("chars")->find($family_id);
            $familyUsers = $family->chars->pluck("char_id")->toArray();
        }
        $guild_id = $familyUser?->family?->faction?->id;
        if ($guild_id) {
            $guild        = Faction::with("families", "families.chars")->find($guild_id);
            $factionUsers = $guild->getAllMember();
        }

        $excludes = ["Lân Cận", "Tổ Đội"];
        foreach ($res as $key => $value) {
            if ($value["from"] == "Nói Thầm") {
                if ($value["uid"] != $char_id && $value["dest"] != $char_id) {
                    unset($res[$key]);
                }
            }

            if ($value["from"] == "Bang Hội") {
                if (! in_array($value["uid"], $factionUsers)) {
                    unset($res[$key]);
                }
            }

            if ($value["from"] == "Gia Tộc") {
                if (! in_array($value["uid"], $familyUsers)) {
                    unset($res[$key]);
                }
            }

            if (in_array($value["from"], $excludes)) {
                unset($res[$key]);
            }
        }
        return view("chats", ["chs" => $res]);

    }

    public function chats()
    {
        try {
            if (! request()->gm2) {
                throw 500;
            }

            $response = $this->callGameApi("get", "/api/chat.php", []);
            $chat     = $response["data"];

            foreach ($chat as &$item) {

                if (in_array($item["channel"], ["Whisper", "Faction", "Party"]) && $item["type"] == "Family") {
                    $item["channel"] = "Family";
                }

                if (in_array($item["channel"], ["Whisper", "Trade", "Party"]) && $item["type"] == "Guild") {
                    $item["channel"] = "Faction";
                }
                $item["msg"] = $this->replaceSmile($item["msg"]);
            }

            $filtered = collect($chat)->filter(function ($value, int $key) {
                return true;
            });

            $chats = $filtered->values()->all();

            foreach ($chats as &$item) {
                switch ($item["type"]) {
                    case 'Chat':
                        if ($item["channel"] == "Party") {
                            $item["from"]  = "Tổ Đội";
                            $item["color"] = "#4ddd4d";
                        } elseif ($item["channel"] == "Common") {
                            $item["from"]  = "Lân Cận";
                            $item["color"] = "white";
                        } else {
                            $item["from"]  = "Thế Giới";
                            $item["color"] = "yellow";
                        }
                        break;
                    case 'Guild':
                        $item["from"]  = "Bang Hội";
                        $item["color"] = "cyan";
                        break;
                    case 'Whisper':
                        $item["from"]  = "Nói Thầm";
                        $item["color"] = "violet";
                        break;
                    case 'Family':
                        $item["from"]  = "Gia Tộc";
                        $item["color"] = "#2121c5";
                        break;
                    default:
                        $item["from"]  = "Thế Giới";
                        $item["color"] = "yellow";
                        break;
                }
            }
        } catch (\Throwable $th) {
            return $th;
            $chats = [];
        }
        $chat     = [];
        $chs      = [];
        $names    = [];
        $char_ids = Char::select("id", "char_id", "name", "vip")->whereIn("char_id", (array) collect($chats)->pluck("uid")->values()->all())->get();
        foreach ($char_ids as $id) {
            array_push($names, [
                "char_id" => $id->char_id,
                "name"    => $id->name,
                "vip"     => $id["vip"],
            ]);
        }

        foreach (array_reverse($chats) as $key => $ch) {
            $found = collect($names)->firstWhere('char_id', $ch["uid"]);
            if ($found) {
                $ch["name"]      = $found["name"];
                $ch["vip"]       = $found["vip"];
                $ch["dest_name"] = collect($names)->firstWhere('char_id', $ch["dest"]) ? collect($names)->firstWhere('char_id', $ch["dest"])["name"] : "";
                array_push($chs, $ch);
            }
        }
        $chats  = Chat::with("char")->where("from", "Thế Giới")->limit(500)->latest()->get()->toArray();
        $all    = array_merge($chats, $chs);
        $sorted = collect($all)->sortByDesc('date');

        $res = $sorted->values()->all();
        $res = collect($res)->unique(function ($item) {
            return $item['uid'] . '-' . $item['date'];
        });
        return view("chats", ["chs" => $res]);

    }

    public function message()
    {
        $api = new API;
        if (strlen(request()->msg) > 200) {
            return back()->with("error", "Tin nhắn quá dài!");
        }

        $user = Auth::user();

        $last = Chat::where("uid", Auth::user()->main_id)->latest()->first();
        if ($last && Carbon::now()->diffInSeconds($last->created_at) < 5) {
            return back()->with("error", "Thao tác quá nhanh, vui lòng thử lại");
        }

        $from = Auth::user()->char->name;
        $ms   = request()->msg;

        $msg = "[WebChat]{$from}: {$ms}";
        sendMsg($msg, 1);

        $chat          = new Chat;
        $chat->date    = date("Y-m-d H:i:s");
        $chat->type    = "Chat";
        $chat->uid     = Auth::user()->main_id;
        $chat->channel = "World";
        $chat->dest    = "1";
        $chat->msg     = "[WebChat]: " . request()->msg;
        $chat->from    = "Thế Giới";
        $chat->color   = "yellow";
        $chat->save();

        return back()->with("success", "Tin nhắn đã được gởi thành công");
    }
}
