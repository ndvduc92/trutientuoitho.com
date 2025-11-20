<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    use HasFactory;

    public const BOSSES = [
        "25949" => "Tần Quảng-",
        "25950" => "Long Nhung-",
        "10671" => "Quỷ Điệp Vương-",
        "10669" => "Côn Luân Nô",
        "10672" => "Thiên Nhẫn Vương-",
        "10673" => "Quỷ Điệp Vương-",
        "10674" => "Anh Mộc Vương-",
        "10675" => "Âm Dương Vương-",
        "10676" => "Phong Hoả Vương-",
        "10677" => "An Thổ Vương-",

        "635"   => "Kim Cang",
        "636"   => "Thần Hỏa Ma Tổ",
        "637"   => "Cự Hùng Yêu",
        "638"   => "Phệ Huyết Ác Tăng",
        "639"   => "Cô Lâu Tướng Quân",
        "640"   => "Ngư Nhân Chu",
        "641"   => "Hải Đạo Thuyền Trưởng",
        "642"   => "Tê Giáp Chi Vương",
        "643"   => "Tử Trạch Ngư Yêu",
        "644"   => "Vạn Trùng Chi Mẫu",
        "645"   => "Tử Trạch Lệ Quỷ",
        "647"   => "Huyết Sư",
        "648"   => "Huyền Minh Ưu Quỷ",
        "10991" => "Hỗn Thế Khô Lâu Vương",
        "10989" => "Hỗn Thế Chiến Tướng",
        "35236" => "Minh Giới·Thiên Lang-",
        "35238" => "Minh Giới·Huyết Sư-",
        "35239" => "Minh Giới·Cổ Viên-",
        "35240" => "Minh Giới·Huyền Điểu-",
        "35241" => "Minh Giới·Thánh Sứ-",
        "35242" => "Minh Giới·Thao Thiết-",
        "35243" => "Minh Giới·Thú Thần-",
        "673"   => "Kim Đồng Yêu Bức",
        "674"   => "Luyện Huyết Tử Sĩ",
        "675"   => "Hắc Thuỷ Huyền Xà",
        "676"   => "Đại Hắc Điệt",
        "677"   => "Diệm Ma",
        "678"   => "Cửu Mệnh Miêu Vương",
        "679"   => "Dung Nham Chi Vương",
        "680"   => "Bào Hao Chi Vương",
        "681"   => "Hồng Hoang Thú Vương",
        "5592"  => "Hoàng Điểu",
        "5593"  => "Chúc Long",
        "5594"  => "Quỳ Ngưu",
        "5595"  => "Thao Thiết",
        "5596"  => "Ngư Nhân Vương",
        "10487" => "Huyền Minh Quỷ Thủ",
        "10491" => "Bất Tử Thiên Thi",
        "10492" => "Bát Hoang Hoả Long",
        "10493" => "Thú Thần",

    ];

    public const REDS = [
        "25949",
        "25950",
        "10671",
        "10669",
        "10672",
        "10673",
        "10674",
        "10675",
        "10676",
        "10677"
    ];

    protected $appends = ['msg'];

    private function isNotMiniBoss($id) {
        return in_array($id, self::REDS) ? "highlight" : "";
    }

    private function getBoss($bossid)
    {
        $bossid = strval($bossid); // ép về string để so key

        if (array_key_exists($bossid, self::BOSSES)) {
            $name = self::BOSSES[$bossid];

            // Nếu có dấu "-", thì cắt và lấy phần đầu tiên
            if (strpos($name, '-') !== false) {
                $parts = explode('-', $name, 2);
                return trim($parts[0]);
            }

            return $name;
        }

        return "Không xác định";
    }

    private function getColor()
    {
        $rand  = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
        $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];
        return $color;
    }

    public function getMsgAttribute()
    {
        $msg     = "";
        $type    = $this->type;
        $vip     = $this->char->vip;
        $vipIcon = $vip > 0 ? "<span class='vip lvl{$vip}'></span>" : "";
        $charId  = $this->char->char_id + 1234;
        $isNotMiniBoss = $this->isNotMiniBoss($this->bossid);
        switch ($type) {
            case 'boss':
                //$msg = "<span class='highlight char char-{$charId}'>[" . ($this->char->name) . "]</span> hạ Boss <span class='highlight'>[" . $this->getBoss($this->bossid) . "]</span>";
                $msg = "<span class='{$isNotMiniBoss} char char-{$charId}'>[" . ($this->getBoss($this->bossid)) . "]</span> đã bị tiêu diệt</span>";
                break;
            case 'login':
                $msg = $this->char->class_icon . "<span class='player'>" . ($this->char->name) . "</span> đã đăng nhập vào game";
                break;
            case 'refine':
                $img  = $this->item->image;
                $name = $this->item->name;
                $msg  = $this->char->class_icon . "<span class='player'>" . ($this->char->name) . "</span> đã tinh luyện thành công <img title='{$name}' class='equipment' src='{$img}' /> +" . $this->refine_level_after . " bằng <span class='stone'>" . $this->stone->name . "</span>";
                break;
            default:
                $msg = "....";
                break;
        }
        return $msg;
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid')->withDefault(["name" => "Không xác định"]);
    }

    public function stone()
    {
        return $this->belongsTo(Item::class, 'refine_stoneid', 'itemid')->withDefault(["name" => "Không xác định"]);
    }

    public function char()
    {
        return $this->belongsTo(Char::class, 'char_id', 'char_id')->withDefault(["name" => "Chưa cập nhật"]);
    }
}
