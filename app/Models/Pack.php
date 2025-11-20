<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(PackItem::class);
    }

    public function getSell()
    {
        return Transaction::where("shop_id", $this->id)->where("type", "pack")->sum("shop_quantity");
    }
}