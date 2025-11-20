<section id="hienviensach">
    <h2>Hiên Viên Sách</h2>
    @foreach (range(1,4) as $i)
    <img class="huongdan" src="/wiki/sach/{{$i}}.jpg" alt="">
    @endforeach
</section>