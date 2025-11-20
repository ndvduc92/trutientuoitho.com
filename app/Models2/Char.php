<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Char extends Model
{
    use HasFactory;

    protected $appends = ['class_name', 'class_icon'];

    public const GMS = [1024,1025,1026,1027,1028];

    public const CLASSES = [
        [
            "class" => "0",
            "img" => "images/poslushik.png",
            "name" => "Thiếu Hiệp",
            "icon" => "0"
        ],
        [
            "class" => "117,118,119,120,121",
            "img" => "images/skayaV.png",
            "name" => "Phá Quân",
            "icon" => "-2420px"
        ],
        [
            "class" => "108,109,110,111,112",
            "img" => "images/skayaV.png",
            "name" => "Anh Chiêu",
            "icon" => "-2240px"
        ],
        [
            "class" => "77,78,79,80,81",
            "img" => "images/skayaV.png",
            "name" => "Quy Vân",
            "icon" => "-1620px"
        ],
        [
            "class" => "83,84,85,86,87",
            "img" => "images/skayaV.png",
            "name" => "Họa Ảnh",
            "icon" => "-1740px"
        ],
        [
            "class" => "102,103,104,105,106",
            "img" => "images/skayaII.png",
            "name" => "Khiên Cơ",
            "icon" => "-2120px"
        ],
        [
            "class" => "71,72,73,74,75",
            "img" => "images/skayaII.png",
            "name" => "Thanh La",
            "icon" => "-1500px"
        ],
        [
            "class" => "56,57,58,59,60",
            "img" => "images/skayaII.png",
            "name" => "Thần Hoàng",
            "icon" => "-1200px"
        ],
        [
            "class" => "51,52,53,54,55",
            "img" => "images/skayaII.png",
            "name" => "Thiên Hoa",
            "icon" => "-1100px"
        ],
        [
            "class" => "33,34,35,36,37",
            "img" => "images/skayaII.png",
            "name" => "Cửu Lê",
            "icon" => "-740px"
        ],
        [
            "class" => "96,97,98,99,100",
            "img" => "images/skayaII.png",
            "name" => "Thái Hạo",
            "icon" => "-980px"
        ],
        [
            "class" => "45,46,47,48,49",
            "img" => "images/skayaII.png",
            "name" => "Hoài Quang",
            "icon" => "-2000px"
        ],
        [
            "class" => "39,40,41,42,43",
            "img" => "images/skayaII.png",
            "name" => "Liệt Sơn",
            "icon" => "-860px"
        ],
        [
            "class" => "64,65,66,67,68",
            "img" => "images/skayaII.png",
            "name" => "Phần Hương Cốc",
            "icon" => "-1360px"
        ],
        [
            "class" => "7,8,9,19,20",
            "img" => "images/skayaII.png",
            "name" => "Thanh Vân Môn",
            "icon" => "-400px"
        ],
        [
            "class" => "10,11,12,22,23",
            "img" => "images/skayaII.png",
            "name" => "Thiên Âm Tự",
            "icon" => "-460px"
        ],
        [
            "class" => "4,5,6,16,17",
            "img" => "images/skayaII.png",
            "name" => "Hợp Hoan Phái",
            "icon" => "-340px"
        ],
        [
            "class" => "1,2,3,13,14",
            "img" => "images/skayaII.png",
            "name" => "Quỷ Vương Tông",
            "icon" => "-280px"
        ],
        [
            "class" => "26,27,28,29",
            "img" => "images/skayaII.png",
            "name" => "Quỷ Đạo",
            "icon" => "-580px"
        ],
    ];

    public const CLASS_ITEM = [
        100807 => "Thanh Vân Môn",
        100803 => "Thiên Âm Tự",
        100805 => "Quỷ Đạo",
        100804 => "Quỷ Vương Tông",
        100808 => "Hợp Hoan Phái",
        100806 => "Phần Hương Cốc",
        1 => "--------------------",
        100810 => "Cửu Lê",
        100809 => "Liệt Sơn",
        100811 => "Hoài Quang",
        100813 => "Thái Hạo",
        100861 => "Thiên Hoa",
        100814 => "Thần Hoàng",
        2 => "--------------------",
        100816 => "Anh Chiêu",
        100815 => "Khiên Cơ",
        100817 => "Thanh La",
        100822 => "Phá Quân",
        100821 => "Quy Vân",
        100820 => "Họa Ảnh",
    ];

    public function getClass()
    {
        $item = collect(self::CLASSES)->first(function ($value, int $key) {
            return in_array($this->class, explode(",", $value["class"]));
        });
        return $item ? $item["name"] : "Chưa cập nhật";
    }

    public function getClassIconAttribute()
    {
        $item = collect(self::CLASSES)->first(function ($value, int $key) {
            return in_array($this->class, explode(",", $value["class"]));
        });
        return $item ? '<i class="race" style="background-position: 0 '.$item["icon"].'";></i>' : "Chưa cập nhật";
    }

    public function getClassNameAttribute()
    {
        $item = collect(self::CLASSES)->first(function ($value, int $key) {
            return in_array($this->class, explode(",", $value["class"]));
        });
        return $item ? $item["name"] : "Chưa cập nhật";
    }

    public function getImage()
    {
        return url('') . "/assets/new/" . $item["img"];
    }

    public function getName()
    {
        return $this->name2 ?? $this->name;
    }

    public function user()
    {
        return $this->belongsTo(User::class, "userid", "userid");
    }

}
