<section id="tranlinh">
    <h2>Trận Linh</h2>
    @foreach (range(1,8) as $i)
    <img class="huongdan" src="/wiki/tranlinh/{{$i}}.jpg" alt="">
    @endforeach

    <br>
    <h2>Trận Tham Khảo</h2>
    @foreach (range(1,3) as $i)
    <img class="huongdan" src="/wiki/tranlinh/TranThamKhao/{{$i}}.jpg" alt="">
    @endforeach
</section>