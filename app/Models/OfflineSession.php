<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineSession extends Model
{
    use HasFactory;

    protected $fillable = ['char_id', 'status', 'start_time', 'end_time'];


    public const DROP_RATES = [
        [
            'item_id'              => 1901, // Xu web
            'item_name'            => 'Xu treo máy',
            'drop_rate_per_minute' => 0.15,
            'min_quantity'         => 1,
            'max_quantity'         => 5,
        ],
        [
            'item_id'              => 63521,
            'item_name'            => 'Thương Lãng Băng Châu',
            'drop_rate_per_minute' => 0.03,
            'min_quantity'         => 1000,
            'max_quantity'         => 4000,
        ],
        [
            'item_id'              => 63522,
            'item_name'            => 'Bảo Liêm Ngọc Trần',
            'drop_rate_per_minute' => 0.015,
            'min_quantity'         => 100,
            'max_quantity'         => 500,
        ],
        [
            'item_id'              => 63523,
            'item_name'            => 'Nguyên Dương Linh Trần',
            'drop_rate_per_minute' => 0.015,
            'min_quantity'         => 100,
            'max_quantity'         => 500,
        ],
        [
            'item_id'              => 65842,
            'item_name'            => 'Hiên Viên Linh Khế',
            'drop_rate_per_minute' => 0.01,
            'min_quantity'         => 100,
            'max_quantity'         => 500,
        ],
        [
            'item_id'              => 53946,
            'item_name'            => 'Quy Nguyên Thánh Ngọc',
            'drop_rate_per_minute' => 0.002,
            'min_quantity'         => 5,
            'max_quantity'         => 10,
        ],
    ];

    public function items()
    {
        return $this->hasMany(OfflineSessionItem::class);
    }
}
