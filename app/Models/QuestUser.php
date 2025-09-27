<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestUser extends Model
{
    use HasFactory;

    public function quest()
    {
        return $this->belongsTo(Quest::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
