<div class="shop-header chars-list">
  <div class="character-dropdown">
    <i class="fas fa-user"></i>
    <select id="Sel_Account">
      @foreach (meta() as $item)
      <option {{Auth::user()->id == $item->id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->username }}</option>
      @endforeach
    </select>
  </div>
  <div class="character-dropdown">
    <i class="fas fa-user"></i>
    <select id="Sel_Role">
      <option value="">---Chọn nhân vật---</option>
      @foreach (Auth::user()->chars() as $item)
      <option {{Auth::user()->main_id == $item->char_id ? 'selected' : ''}} value="{{ $item->char_id }}">{!!
        $item->class_icon !!} {{ $item->getName() }} [{{ $item->char_id }}]</option>
      @endforeach
      <option value="Không thấy nhân vật?">Cập nhật nhân vật?</option>
    </select>
  </div>
</div>

<script>
  $("#Sel_Role").change(function() {
    var selectedValue = $(this).val();
    if (selectedValue === "Không thấy nhân vật?") {
      window.location.href = "/chars";
    } else {
      if (selectedValue) {
          window.location.href = `/set_main_char/${selectedValue}`;
      }
    }
  });

  $("#Sel_Account").change(function() {
    var selectedValue = $(this).val();
    window.location.href = `/meta/login/${selectedValue}`;
  });
</script>