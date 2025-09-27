<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementItem extends Model
{
    use HasFactory;

    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'user_id');
    }
}
