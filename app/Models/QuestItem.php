<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestItem extends Model
{
    use HasFactory;

    protected $appends = ['image'];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function getImageAttribute()
    {
        return "https://items.trutienvietnam.com/icons/" . $this->itemid . ".png";
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid')->withDefault(["name" => "Không xác định"]);
    }
}
