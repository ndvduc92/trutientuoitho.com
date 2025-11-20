<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $appends = ['picture'];

    public function getSell()
    {
        return Transaction::where("shop_id", $this->id)->sum("shop_quantity");
    }

    public function getPictureAttribute()
    {
        return "https://items.trutiendailuc.com/icons/" . $this->itemid . ".png";
    }

    public function countByChar()
    {
        return Transaction::where("shop_id", $this->id)->where("char_id", current_user()->main_id)->sum("shop_quantity");
    }

    public function countByDate()
    {
        return Transaction::where("type", "war")->where("shop_id", $this->id)->where("char_id", current_user()->main_id)->whereDate("created_at", Carbon::today())->sum("shop_quantity");
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid')->withDefault(["name" => "Không xác định"]);
    }
}
