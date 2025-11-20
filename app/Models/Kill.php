<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kill extends Model
{
    use HasFactory;

    public function char_kill()
    {
        return $this->belongsTo(Char::class, "kill", "char_id");
    }

    public function char_be_killed()
    {
        return $this->belongsTo(Char::class, "be_killed", "char_id");
    }
}
