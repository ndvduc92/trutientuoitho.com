<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    protected $appends = ["type", "value", "trang_thai", "msg"];

    public function getTypeAttribute() {
        $type = [
            "de" => "Số đề",
            "3cang" => "3 càng",
            "odd_even" => "Khác"
        ];
        return $type[$this->bet_type];
    }

    public function getValueAttribute() {
        $type = [
            "odd" => "Chẵn",
            "even" => "Lẻ",
            "kep" => "Kép",
            "tai" => "Tài",
            "xiu" => "Xỉu"
        ];
        if ($this->bet_type == "odd_even") {
            return $type[$this->odd_even];
        }
        return $this->number;
    }
    
    public function getMsgAttribute() {
        $types = [
            'de'       => "Số đề",
            '3cang'    => "3 càng",
            'odd_even' => "Chẵn/Lẻ/Kép/Tài/Xỉu",
        ];
        
        $type2s = [
            'odd'       => "Chẵn",
            'tai'       => "Tài",
            'xiu'       => "Xỉu",
            'even'    => "Lẻ",
            'kep' => "Kép",
        ];
        $typex = $types[$this->bet_type];
        $chanle = $type2s[$this->odd_even];
        $number = $this->number;
        $name = $this->user->char ? $this->user->char->name : $this->user->username;
        $amount = number_format($this->prize);
        $type = $this->coin_type == "knb" ? "xu nạp" : "xu war";
        $vip = $this->user->viplevel;
        $vipIcon = $vip > 0 ? "<span class='vip lvl{$vip}'></span>" : "";
        if ($this->bet_type == "odd_even") {
            $msg = "<span class='player'>" . ($name) . "</span> đã thắng cược <span class='amount'>{$amount}</span> ({$type}) xổ số miền Bắc (ngày ". $this->date . ") cho kèo [{$typex}]: {$chanle}";
        } else {
            $msg = "<span class='player'>" . ($name) . "</span> đã thắng cược <span class='amount'>{$amount}</span> ({$type}) xổ số miền Bắc (ngày ". $this->date . ") cho kèo [{$typex}]: {$number}";
        }
        return $msg;
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    

    public function getTrangThaiAttribute() {
        $type = [
            "pending" => "Đang chờ",
            "won" => "Thắng cược",
            "lost" => "Thua cược"
        ];
        return $type[$this->status];
    }
}
