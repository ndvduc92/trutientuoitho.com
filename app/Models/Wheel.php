<?php
namespace App\Models;

use App\Models\WheelItem;
use App\Models\WheelUser;
use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Wheel extends Model
{

    public const TYPES = [
        'daily' => "Vòng quay hàng ngày",
        'vip'   => "Vòng quay dành cho vip",
        'coin'  => "Vòng quay tiêu xu",
    ];

    public function items()
    {
        return $this->hasMany(WheelItem::class);
    }

    public function usedTimes($type = "all")
    {
        $query = WheelUser::where("user_id", \Auth::user()->id);
        switch ($type) {
            case 'all':
                return $query->whereDate('created_at', Carbon::today())->count();
                break;
            case 'free':
                return $query->where("type", "free")->whereDate('created_at', Carbon::today())->count();
                break;
            case 'vip':
                return $query->where("type", "vip")->whereDate('created_at', Carbon::today())->count();
                break;
            case 'plus':
                return $query->where("type", "plus")->count();
                break;
            default:
            return $query->whereDate('created_at', Carbon::today())->count();
                break;
        }
    }
}
