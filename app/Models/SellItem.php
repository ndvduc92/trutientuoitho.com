<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellItem extends Model
{
    use HasFactory;

    protected $appends = ['image'];

    protected $fillable = ['trade_id', 'itemid', 'quanity'];

    public function getImageAttribute()
    {
        return "https://items.trutienvietnam.com/icons/" . $this->itemid . ".png";
    }

    public function sell()
    {
        return $this->belongsTo(Sell::class, 'user_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid')->withDefault(["name" => "Không xác định"]);
    }
}
