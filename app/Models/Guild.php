<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use HasFactory;
    protected $appends = ['picture'];

    public function getSell()
    {
        return Transaction::where("shop_id", $this->id)->where("type", "war")->sum("shop_quantity");
    }

    public function getPictureAttribute()
    {
        return "https://items.trutienvietnam.com/icons/" . $this->itemid . ".png";
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid')->withDefault(["name" => "Không xác định"]);
    }
}
