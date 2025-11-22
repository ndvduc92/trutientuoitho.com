<select name="" id="char" class="form-control form-control-sm">
  @if(count(Auth::user()->chars()) == 0)
    <option value="-">Chưa có</option>
  @else
    @foreach (Auth::user()->chars() as $char)
      <option value="{{$char->char_id}}" <?=($char->char_id == Auth::user()->main_id) ? "selected" : ""?> >{{$char->name}}</option>
    @endforeach
  @endif
  <option value="0">Cập nhật</option>
</select>

<script>
  document.getElementById('char').addEventListener('change', function() {
    const charId = (this.value);
    if (charId === "0") {
        window.location.href = "/account/chars";
      } else {
        window.location.href = `/account/set_main_char/${charId}`;
      }
  });
</script>
