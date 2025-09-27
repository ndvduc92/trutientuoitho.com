<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    public const COLORS = [
        'Màu đen'           => '#000000',
        'Màu trắng'         => '#ffffff',
        'Màu xanh dương'    => '#0000ff',
        'Màu đỏ'            => '#ff0000',
        'Màu vàng'          => '#ffff00',
        'Màu hồng tím'      => '#ff00ff',
        'Màu cam'           => '#ff9900',
        'Màu vàng cam'      => '#ffbc3c',
        'Màu xanh lam nhạt' => '#7ea2ff',
        'Màu nâu đậm'       => '#804020',
        'Màu xanh lá sáng'  => '#93df00',
        'Màu xanh vàng'     => '#c8dd56',
        'Màu xanh lam tươi' => '#2785f6',
        'Màu xanh lá non'   => '#6cfb4b',
        'Màu xanh tím nhạt' => '#a195ff',
        'Màu tím đậm'       => '#5d09a1',
        'Màu tím hồng'      => '#aa3fb5',
        'Màu xám nhạt'      => '#e3e3e3',
        'Màu vàng nhạt'     => '#ffdc50',
        'Màu hồng phấn'     => '#f95db9',
        'Màu hồng sen'      => '#ff3366',
        'Màu hồng cánh sen' => '#ff00ae',
        'Màu hồng đậm'      => '#ff4cac',
        'Màu cam đào'       => '#ff8f62',
    ];

    public const STATUSES = [
        "pending" => "Chưa trao",
        "done" => "Đã trao",
        "invalid" => "Không phù hợp"
    ];

    public function char()
    {
        return $this->belongsTo(Char::class, "char_id", "char_id")->withDefault(["name" => "Không xác định"]);
    }
}
