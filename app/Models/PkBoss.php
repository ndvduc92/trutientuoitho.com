<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PkBoss extends Model
{
    use HasFactory;

    protected $appends = ['msg', "category"];

    public function char_kill()
    {
        return $this->belongsTo(Char::class, "kill", "char_id")->withDefault(["name" => "Không xác định"]);
    }

    public function char_be_killed()
    {
        return $this->belongsTo(Char::class, "be_killed", "char_id")->withDefault(["name" => "Không xác định"]);
    }

    public function getMsgAttribute()
    {
        $vipKill     = $this->char_kill?->class_icon;
        $vipBeKilled = $this->char_be_killed?->class_icon;
        $charKillId = $this->char_kill?->char_id + 1234;
        $charBeKilled = $this->char_be_killed?->char_id + 1234;
        $msg         = "<span class='sword-glow'>⚔️</span>️{$vipKill}<span class ='char char-{$charKillId}'>{$this->char_kill?->name}</span><span style='color: red'> đã hạ gục </span> <span class ='char char-{$charBeKilled}'>{$vipBeKilled}{$this->char_be_killed?->name}</span>";
        return $msg;
    }

    public function get_char_kill_class()
    {
        return $this->char_kill->blink == `yes` ? `demo rainbow` : ``;
    }

    public function getCategoryAttribute()
    {
        return "pk_boss";
    }
}
