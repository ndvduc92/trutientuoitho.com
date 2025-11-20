<section id="boichuong">
    <h2>Bội Chương</h2>
    @foreach (range(1,8) as $i)
    <img class="huongdan" src="/wiki/bc/{{$i}}.jpg" alt="">
    @endforeach
</section>