@extends('layouts.master')
@section('content')
@section('heading')
    Lịch sử nhận phúc lợi
@endsection
@php
    $activeClass =
        'flex flex-1 justify-center px-4 py-2 font-semibold dark:border-primary border-b -mb-px opacity-100 border-l border-t border-r rounded-t bg-gray-50 dark:bg-primary';
    $normalClass = 'flex flex-1 justify-center px-4 py-2 font-semibold';
@endphp
<div class="col-span-3">
    <!-- Tab Contents -->
    <div class="p-4 mx-auto">
        @if (count($items))
            <div
                class="bg-white dark:bg-primary shadow-md rounded border border-gray-300 dark:border-primary-light justify-items-center">
                <table class="w-full table-auto">
                    <thead>
                        <tr
                            class="bg-gray-200 dark:bg-primary dark:text-light text-gray-600 uppercase text-xs leading-normal">
                            <th class="py-3 px-6 text-left">#</th>
                            <th class="py-3 px-6 text-left">Ngày nhận</th>
                            <th class="py-3 px-6 text-left">Thời gian nhận</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-xs dark:text-light">
                        @foreach ($items as $item)
                            <tr
                                class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100 dark:border-primary dark:bg-darker dark:hover:bg-primary-dark">
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ $loop->index + 1 }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex items-center">
                                        <span>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            Chưa có giao dịch nào!
        @endif

    </div>
</div>
@endsection
