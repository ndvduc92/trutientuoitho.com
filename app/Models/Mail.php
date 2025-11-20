<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;
    public const BIND_TYPES = [
        "BIND" => 19,
        "NOT_BIND" => 0,
    ];
}
