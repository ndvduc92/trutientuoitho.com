<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharItem extends Model
{
    use HasFactory;

    public const ITEMS = [
        "63521"  => 30000,
        "63522"  => 30000,
        "63523"  => 30000,
        "21154"  => 30000,
        "19681"  => 30000,
        "41171"  => 30000,
        "18794"   => 30000,
        "88806"  => 99,
        "88807"  => 99,
        "65842"  => 30000,
        "201377"  => 99,
        "55525"  => 99,
        "53946"  => 30000,
        "201372" => 999,
        "88113"  => 999,
        "71488"  => 999,
        "88821"  => 99,
        "40548"  => 99,
        "201372" => 99,
        "84141"  => 30000,
    ];

    protected $appends = ['image', 'stack'];

    protected $fillable = ['char_id', 'itemid', 'quantity'];

    public function getImageAttribute()
    {
        return "https://items.trutiendailuc.com/icons/" . $this->itemid . ".png";
    }

    public function getStackAttribute()
    {
        return self::ITEMS[$this->itemid] ?? 1;
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid')->withDefault(["name" => "Không xác định"]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function char()
    {
        return $this->belongsTo(Char::class);
    }
}
