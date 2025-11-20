<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarHistory extends Model
{
    use HasFactory;

    public function char()
    {
        return $this->belongsTo(Char::class);
    }
}
