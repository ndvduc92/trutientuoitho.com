<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xếp Hạng Bảng Chiến</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background-color: #0d1a29;
            /* Màu nền xanh đậm tương tự ảnh */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #e0e0e0;
            /* Màu chữ sáng */
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            background-color: #1a2a3e;
            /* Nền của box chính */
            border: 2px solid #3a5c8a;
            /* Viền ngoài của box chính */
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 95%;
            /* Tối ưu cho màn hình rộng */
            max-width: 1200px;
            /* Giới hạn chiều rộng tối đa */
            display: flex;
            flex-direction: column;
            gap: 15px;
            overflow: hidden;
            /* Đảm bảo nội dung không tràn ra ngoài */
        }

        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #3a5c8a;
        }

        .header h1 {
            color: #ffd700;
            /* Màu vàng */
            font-size: 2.2em;
            text-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
            margin: 0;
        }

        .content {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            /* Cho phép các cột xuống hàng nếu không đủ chỗ */
        }

        .team {
            flex: 1;
            /* Cho phép các đội chiếm không gian bằng nhau */
            min-width: 350px;
            /* Chiều rộng tối thiểu cho mỗi đội */
            background-color: #0e1e2d;
            /* Nền của mỗi đội */
            border: 1px solid #2a4b6c;
            border-radius: 5px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .team-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 5px;
            border-bottom: 1px solid #2a4b6c;
        }

        .team-header h2 {
            margin: 0;
            font-size: 1.4em;
            color: #87ceeb;
            /* Màu xanh da trời */
            text-shadow: 0 0 5px rgba(135, 206, 235, 0.5);
        }

        .score span:first-child {
            color: #e0e0e0;
            margin-right: 5px;
        }

        .score span:last-child {
            color: #ff4500;
            /* Màu cam đỏ cho số điểm */
            font-weight: bold;
        }

        .player-list {
            overflow-y: auto;
            /* Tạo thanh cuộn nếu danh sách quá dài */
            /* Chiều cao tối đa cho danh sách người chơi */
            scrollbar-width: thin;
            /* Kích thước thanh cuộn */
            scrollbar-color: #3a5c8a #1a2a3e;
            /* Màu thanh cuộn */
        }

        .player-list table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95em;
        }

        .player-list th,
        .player-list td {
            padding: 6px 8px;
            text-align: left;
            border-bottom: 1px solid #2a4b6c;
        }

        .player-list th {
            background-color: #15314d;
            color: #b0c4de;
            font-weight: normal;
        }

        .player-list tbody tr:nth-child(even) {
            background-color: #122538;
        }

        .player-list tbody tr:hover {
            background-color: #1f3d5a;
        }

        .highlighted {
            background-color: #3a5c8a !important;
            /* Dòng được highlight */
            color: #ffd700;
            font-weight: bold;
        }

        /* Custom scrollbar for Webkit browsers */
        .player-list::-webkit-scrollbar {
            width: 8px;
        }

        .player-list::-webkit-scrollbar-track {
            background: #1a2a3e;
            border-radius: 10px;
        }

        .player-list::-webkit-scrollbar-thumb {
            background: #3a5c8a;
            border-radius: 10px;
        }

        .player-list::-webkit-scrollbar-thumb:hover {
            background: #4a6c9a;
        }


        .middle-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 20px;
            padding: 10px;
            min-width: 150px;
            /* Đảm bảo đủ không gian cho các chữ */
        }

        .time-info {
            text-align: center;
            font-size: 1.1em;
            color: #b0c4de;
        }

        .time-info p:last-child {
            font-size: 1.5em;
            font-weight: bold;
            color: #ffd700;
        }

        .ranking-terms {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .ranking-terms .term {
            font-weight: bold;
            color: #ff8c00;
            /* Màu cam đậm */
            text-shadow: 0 0 10px rgba(255, 140, 0, 0.8), 0 0 20px rgba(255, 140, 0, 0.5);
            /* Các hiệu ứng cụ thể cho từng chữ sẽ phức tạp hơn */
            /* Có thể dùng gradient hoặc SVG/hình ảnh cho hiệu ứng tốt nhất */
            text-align: center;
        }

        /* Các lớp cho từng chữ riêng biệt nếu muốn màu hoặc hiệu ứng khác nhau */
        .term-vinh {
            color: #f7b731;
            text-shadow: 0 0 10px #f7b731, 0 0 20px rgba(247, 183, 49, 0.7);
        }

        .term-dieu {
            color: #f7a231;
            text-shadow: 0 0 10px #f7a231, 0 0 20px rgba(247, 162, 49, 0.7);
        }

        .term-dien {
            color: #f78d31;
            text-shadow: 0 0 10px #f78d31, 0 0 20px rgba(247, 141, 49, 0.7);
        }

        .term-duong {
            color: #f77831;
            text-shadow: 0 0 10px #f77831, 0 0 20px rgba(247, 120, 49, 0.7);
        }


        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
                align-items: center;
            }

            .team {
                width: 100%;
                max-width: 500px;
                /* Giới hạn chiều rộng khi ở chế độ cột */
            }

            .middle-section {
                flex-direction: row;
                /* Thay đổi hướng cho phần giữa trên màn hình nhỏ */
                justify-content: space-around;
                width: 100%;
                gap: 10px;
            }

            .ranking-terms {
                flex-direction: row;
                /* Các chữ nằm ngang trên màn hình nhỏ */
                gap: 10px;
            }

            .ranking-terms .term {
                font-size: 2em;
            }

            .footer {
                flex-direction: column;
                gap: 10px;
            }

            .footer-left {
                flex-wrap: wrap;
                justify-content: center;
            }

            .actions {
                flex-direction: column;
                gap: 10px;
            }

            .actions button {
                width: 80%;
                max-width: 300px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Xếp hạng bang chiến</h1>
        </div>
        <div class="content">
            <div class="team team-bigbang">
                <div class="team-header">
                    <h2>⭐Galaxy⭐</h2>
                    <div class="score">
                        <span>Giết</span>
                        <span>{{collect($data['galaxy'])->sum('war_kill')}}</span>
                    </div>
                </div>
                <div class="player-list">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Giết</th>
                                <th>Chết</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($data['galaxy'] as $char)
                            <tr>
                                <td>{{$char["name"]}}</td>
                                <td>{{$char["war_kill"]}}</td>
                                <td>{{$char["war_be_killed"]}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="middle-section">

            </div>

            <div class="team team-galaxy">
                <div class="team-header">
                    <h2>⭐TamQuốc⭐</h2>
                    <div class="score">
                        <span>Giết</span>
                        <span>{{collect($data['tamquoc'])->sum('war_kill')}}</span>
                    </div>
                </div>
                <div class="player-list">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Giết</th>
                                <th>Chết</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($data['tamquoc'] as $char)
                            <tr>
                                <td>{{$char["name"]}}</td>
                                <td>{{$char["war_kill"]}}</td>
                                <td>{{$char["war_be_killed"]}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>