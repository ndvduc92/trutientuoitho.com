@extends('layouts.master')
@section('heading')
    MUA GÓI ĐẦU TƯ
@endsection
@php
    $char = Auth::user()->main_id ? Auth::user()->char->name : "Chưa chọn nhân vật";
@endphp
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <style>
        .gm-panel {
            display: none;
        }
    </style>

    @php
        $enableClass = "me-2 mb-2 px-5 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg
hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700
dark:focus:ring-green-800";
        $disableClass = "py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border
border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100
dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white
dark:hover:bg-gray-700";
    @endphp

    <div class="col-span-3">
        <div class="dark:bg-darker shadow-lg hover:shadow-xl rounded-lg mb-6 border dark:border-primary-light">
            <div class="p-2 dark:text-primary-light border-b dark:border-primary-light">
                <h2 class="text-2xl font-semibold ">Hướng dẫn</h2>
            </div>
            <div class="p-2">
                <p>Sẽ có 2 loại gói đầu tư: Gói Tháng và Gói Tuần
                </p>
                <code>* * * * * Có thể mua 2 gói cùng 1 lúc</code>
                <br>
                <code style="color:red">* Lưu ý: KNB Hồng lợi nhận theo [NHÂN VẬT ĐƯỢC CHỌN] nên vui lòng chọn nhân vật trước</code>
                <br>
                <code style="color:red">* Nhân vật đang được chọn là [{{ $char }}]</code>
                <br>

            </div>
        </div>
    </div>

    <div class="col-span-3">
        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2">
            <form action="" method="post">
                @csrf
                <div
                    class="flex flex-col dark:bg-darker shadow-lg hover:shadow-xl rounded-lg mb-6 border dark:border-primary-light h-full">
                    <div
                        class="flex flex-row p-2 align-middle align-center dark:text-primary-light border-b dark:border-primary-light">
                        <svg class="w-11 h-11 pr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            class="bi bi-award-fill" viewBox="0 0 16 16">
                            <path
                                d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864z" />
                            <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1z" />
                        </svg>
                        <div class="flex flex-col">
                            <h2 class="font-extrabold">
                                Gói đầu tư Tuần
                            </h2>
                            <span class="text-sm">
                                Giá: 100.000 xu
                            </span>
                        </div>
                    </div>
                    <div class="p-2 mt-2 text-sm">
                        <span>Phúc lợi của [Gói Tuần]</span>
                        <span class="block" style="color:green">- Ngay lập tức nhận được 100 KNB</span>
                        <span class="block" style="color:green">- Mỗi ngày được nhận thêm 5 KNB Hồng Lợi (nhận ở Tín Sứ)</span>
                        <br>
                        <span>Tình trạng</span>
                        @if ($week)
                            <span class="block" style="color:green">- Đang sử dụng</span>
                            <span class="block" style="color:green">- Thời hạn: {{ dateFormat($week->start_date) }} -
                                {{ dateFormat($week->end_date) }}</span>
                        @else
                            <span class="block" style="color:green">- Không có</span>
                        @endif
                    </div>
                    <div class="p-2">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-cyan-500 focus:outline-none focus:ring-0 focus:border-cyan-600 peer"
                            name="type" value="week" type="hidden" placeholder="Tin nhắn" required maxlength="200">
                    </div>
                    <div class="mt-auto items-center justify-between p-2">
                        <button type="submit"
                            onclick="return confirm('Bạn có xác nhận mua gói Tuần cho nhân vật {{$char}} không?')"
                            {{ $week ? "disabled" : "" }}
                            class="{{ $week ? $disableClass : $enableClass }} w-full">
                            {{ $week ? "Đã Mua" : "Mua Gói Tuần" }}
                        </button>
                    </div>
                </div>
            </form>
            <form action="" method="post">
                @csrf
                <div
                    class="flex flex-col dark:bg-darker shadow-lg hover:shadow-xl rounded-lg mb-6 border dark:border-primary-light h-full">
                    <div
                        class="flex flex-row p-2 align-middle align-center dark:text-primary-light border-b dark:border-primary-light">
                        <svg class="w-11 h-11 pr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            class="bi bi-award-fill" viewBox="0 0 16 16">
                            <path
                                d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864z" />
                            <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1z" />
                        </svg>
                        <div class="flex flex-col">
                            <h2 class="font-extrabold">
                                Gói đầu tư Tháng
                            </h2>
                            <span class="text-sm">
                                Giá: 500.000 xu
                            </span>
                        </div>
                    </div>
                    <div class="p-2 mt-2 text-sm">
                        <span>Phúc lợi của [Gói Tháng]</span>
                        <span class="block" style="color:green">- Ngay lập tức nhận được 500 KNB</span>
                        <span class="block" style="color:green">- Mỗi ngày được nhận thêm 20 KNB Hồng Lợi (nhận ở Tín Sứ)</span>
                        <br>
                        <span>Tình trạng</span>
                        @if ($month)
                            <span class="block" style="color:green">- Đang sử dụng</span>
                            <span class="block" style="color:green">- Thời hạn: {{ dateFormat($month->start_date) }} -
                                {{ dateFormat($month->end_date) }}</span>
                        @else
                            <span class="block" style="color:green">- Không có</span>
                        @endif
                    </div>
                    <div class="p-2">
                        <input
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-cyan-500 focus:outline-none focus:ring-0 focus:border-cyan-600 peer"
                            name="type" type="hidden" value="month" required maxlength="30">
                    </div>
                    <div class="mt-auto items-center justify-between p-2">
                        <button type="submit"
                            onclick="return confirm('Bạn có xác nhận mua gói Tháng cho nhân vật {{$char}} không?')"
                            {{ $month ? "disabled" : "" }}
                            class="{{ $month ? $disableClass : $enableClass }} w-full">
                            {{ $month ? "Đã Mua" : "Mua Gói Tháng" }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
