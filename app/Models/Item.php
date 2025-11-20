<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $appends = ['image'];

    public function getImageAttribute()
    {
        return "https://items.trutiendailuc.com/icons/" . $this->itemid . ".png";
    }
}
