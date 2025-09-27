<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use \Carbon\Carbon;

class Quest extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(QuestItem::class);
    }

    public function beDoneByUser()
    {
        $used = $this->users()->where("char_id", Auth::user()->main_id)->whereDate('date', Carbon::today())->first();
        return $used ? true : false;
    }

    public function users() {
        return $this->hasMany(QuestUser::class);
    }
}
