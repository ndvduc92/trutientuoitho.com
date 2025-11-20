<?php

namespace App\Models;

use App\Models\Char;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getCharName()
    {
        $char = Char::where("char_id", $this->char_id)->first();
        return $char->name2 ?? $char->name;
    }

    public function vip()
    {
        return $this->belongsTo(Vip::class);
    }


    public function getCoinType() {
        $types = [
            "knb" => "Xu nạp",
            "war_knb" => "Xu war"
        ];
        return $types[$this->type];
    }

    public function getCoinValue() {
        if ($this->type == "knb") {
            return $this->knb_amount * 1000;
        }
        return $this->knb_amount;
    }
}
