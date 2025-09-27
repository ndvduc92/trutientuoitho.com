<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuildUser extends Model
{
    use HasFactory;

    public function guild()
    {
        return $this->belongsTo(Giftcode::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(Giftcode::class, 'user_id');
    }

    public function char()
    {
        return $this->belongsTo(Char::class, 'char_id', 'char_id');
    }
}