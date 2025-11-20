@extends('layouts.master')
@section('content')

<div class="rewards-grid">
    @foreach ($packs as $item)
    <div class="reward-card">
        <div class="reward-header">
            <h4 class="reward-name">{{ $item->name }}</h4>
        </div>

        <div class="reward-body">
            <div class="reward-requirement requirement-not-met">
                <i class="fas fa-crown"></i>Giá: {{ number_format($item->price) }} xu
            </div>
            <div class="reward-items">
                @foreach ($item->items as $it)
                <div class="reward-item">
                    <div class="reward-item-icon">
                        <img src="{{ $it->item->image }}">
                    </div>

                    <span class="reward-item-name">
                        {{ $it->item->name }} </span>
                    <span class="reward-item-quantity">x{{$it->quantity }}</span>
                </div>
                @endforeach
            </div>

            <!-- Action buttons -->
            <div class="reward-actions">
                <a href="/packs/{{ $item->id }}/buy" class="btn btn-primary btn-block" style="width:100%">
                    <i class="fa-solid fa-circle-check"></i> Mua gói
                </a>
            </div>

        </div>
    </div>
    @endforeach
</div>
@endsection