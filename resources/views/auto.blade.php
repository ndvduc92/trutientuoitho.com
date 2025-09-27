@extends('layouts.master')
@section('content')
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-rotate"></i> Hướng dẫn
    </div>

    <div class="security-tips">
        <div class="security-tips-header">
            <i class="fas fa-shield-alt"></i> Một số lưu ý
        </div>
        <ul style="width: 100%;">
            <li>Tải file giảm lag tuỳ theo cấu hình máy
            </li>
            <li>
                Chép đè vào thư mục game <span style="color:red">TruTienDaiLuc1792/element</span>
            </li>
            <li>Nếu có vấn đề xảy ra, tải lại file gốc (Full)</li>
        </ul>
    </div>
</div>
<div class="account-section">
    <div class="account-section-title">
        <i class="fas fa-crown"></i> Tải giảm lag</span>
    </div>

    <table id="killers-table">
        <thead>
            <tr>
                <th class="py-3 px-6 text-left">Tỉ lệ</th>
                <th class="py-3 px-6 text-left">File tải</th>
                <th class="py-3 px-6 text-left">Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="py-3 px-6 text-left">20%</th>
                <th class="py-3 px-6 text-left"><a href="https://trutienvietnam.com/giamlag/20/gfx.pck">Tải về</a></th>
                <th class="py-3 px-6 text-left">Máy cấu hình khá</th>
            </tr>
            <tr>
                <th class="py-3 px-6 text-left">80%</th>
                <th class="py-3 px-6 text-left"><a href="https://trutienvietnam.com/giamlag/80/gfx.pck">Tải về</a></th>
                <th class="py-3 px-6 text-left">Máy cấu hình trung bình</th>
            </tr>
            <tr>
                <th class="py-3 px-6 text-left">95%</th>
                <th class="py-3 px-6 text-left"><a href="https://trutienvietnam.com/giamlag/95/gfx.pck">Tải về</a></th>
                <th class="py-3 px-6 text-left">Máy cấu hình yếu</th>
            </tr>
            <tr>
                <th class="py-3 px-6 text-left">Full</th>
                <th class="py-3 px-6 text-left"><a href="https://trutienvietnam.com/giamlag/full/gfx.pck">Tải về</a>
                </th>
                <th class="py-3 px-6 text-left">Mặc định full hiệu ứng</th>
            </tr>
        </tbody>
    </table>

</div>
@endsection