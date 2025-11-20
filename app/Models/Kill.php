<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
    use HasFactory;

    protected $appends = ['msg', "category"];

    public function char_kill()
    {
        return $this->belongsTo(Char::class, "kill", "char_id");
    }

    public function getMsgAttribute()
    {
        $vipKill     = $this->char_kill?->class_icon;
        $vipBeKilled = $this->char_be_killed?->class_icon;
        $charKillId = $this->char_kill?->char_id + 1234;
        $charBeKilled = $this->char_be_killed?->char_id + 1234;
        $msg         = "{$vipKill}<span class ='char char-{$charKillId}'>{$this->char_kill?->name}</span><span style='color: red'> đã hạ gục </span> <span class ='char char-{$charBeKilled}'>{$vipBeKilled}{$this->char_be_killed?->name}</span>";
        return $msg;
    }

    public function getCategoryAttribute()
    {
        return "war";
    }

    public function char_be_killed()
    {
        return $this->belongsTo(Char::class, "be_killed", "char_id");
    }
}
