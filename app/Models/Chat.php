<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $appends = ["vip", "name"];

    public function getVipAttribute()
    {
        return $this->char?->vip;
    }

    public function getNameAttribute()
    {
        return $this->char?->name;
    }

    public function char()
    {
        return $this->belongsTo(Char::class, "uid", "char_id");
    }
}
