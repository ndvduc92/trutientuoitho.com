<section class="container">
    <h2 class="text-center">
        <img class="img-fluid" src="/assets/tmcd.png?ver=1.9" alt="" style="max-width: 70%;">
    </h2>
    <div class="bxh">
        <div class="bxh-image">
            <ul class="bxh-btn">
                <li>
                    <span role="button" style="cursor: pointer" class="bxh_btn active" id="bxh_pk">
                        Chiến tích
                    </span>
                </li>
                <li>
                    <span role="button" style="cursor: pointer" class="bxh_btn " id="bxh_war">
                        War mới nhất
                    </span>
                </li>
                <li>
                    <p style="color:white; text-align:center">({{Carbon\Carbon::parse($date)->format("d/m/Y")}})</p>
                </li>
            </ul>
        </div>
        <table class="bxh-table" style="background-color: transparent; font-size: 0.8125rem;" id="table_pk">
            <thead>
                <tr>
                    <th>Hạng</th>
                    <th>Tên Nhân Vật</th>
                    <th>Sát Địch</th>
                    <th>Tử Vong</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pk as $item)
                <tr>
                    <td>
                        @if($loop->index < 3) <img src="/assets/level-{{$loop->index+1}}.png?ver=1.86" alt="">
                            @else
                            {{$loop->index+1}}
                            @endif
                    </td>
                    <td><span data-toggle="tooltip" data-placement="top" title="{{ $item['class_name'] }}">{!! $item["class_icon"] !!}</span> {{$item["name"]}}</td>
                    <td>{{ $item["kill"] }}</td>
                    <td>{{ $item["be_killed"] }}<br></td>
                </tr>
                @endforeach

            </tbody>
        </table>
        <table class="bxh-table" style="background-color: transparent; font-size: 0.8125rem;" hidden id="table_war">
            <thead>
                <tr>
                    <th>Hạng</th>
                    <th>Tên Nhân Vật</th>
                    <th>Sát Địch</th>
                    <th>Tử Vong</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($last as $item)
                <tr>
                    <td>
                        @if($loop->index < 3) <img src="/assets/level-{{$loop->index+1}}.png?ver=1.86" alt="">
                            @else
                            {{$loop->index+1}}
                            @endif
                    </td>
                    <td><span data-toggle="tooltip" data-placement="top" title="{{ $item['class_name'] }}">{!! $item["class_icon"] !!}</span> {{$item["name"]}}</td>
                    <td>{{ $item["kill"] }}</td>
                    <td>{{ $item["be_killed"] }}<br></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</section>

<style>
    table {
        display: flex;
        flex-flow: column;
        width: 100%;
    }

    table thead {
        flex: 0 0 auto;
        width: 100%;
    }

    table tbody {
        flex: 1 1 auto;
        display: block;
        height: 359px;
        overflow-y: auto;
    }

    table tbody tr {
        width: 100%;
    }

    table thead,
    table tbody tr {
        display: table;
        table-layout: fixed;
    }
    ::-webkit-scrollbar {
  width: 1px;
}
</style>

@section('script')
<script>
    $(".bxh_btn").click(function() {
        const type = $(this).attr("id").split("_")[1]
        $(".bxh_btn").removeClass("active")
        $(this).addClass("active")

        $(".bxh-table").attr("hidden", true)
        $(`#table_${type}`).attr("hidden", false)
    })
</script>
@endsection