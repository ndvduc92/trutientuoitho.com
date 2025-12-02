@extends('account.layouts.master')
@section('content')
<h1 class="h3 mb-3">Đổi môn phái</h1>
<div class="tab-content">
    <div class="tab-pane fade show active" id="account" role="tabpanel">

        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger" role="alert">
                    <div class="alert-message">
                        <h4 class="alert-heading">⛔ Một số lưu ý</h4>
                        <p>Chi phí: <font color="red">100,000</font> xu cho 1 lần đổi môn phái</p>
                        <p>Chỉ đổi class không hỗ trợ gì cả !</p>
                    </div>

                </div>
                <form id="contact-form" action="" method="post" style="margin-top: 20px;">
                    @csrf

                    <div class="form-group character-radio">
                        @foreach (\App\Models\Char::CLASS_ITEM as $key => $value)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="class" value="{{ $key }}"
                                id="class_{{ $key }}">

                            <label class="form-check-label" for="class_{{ $key }}">
                                {{ $value }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="col-4 mt-3">
                        <button type="submit" class="btn btn-primary">Đổi môn phái</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection