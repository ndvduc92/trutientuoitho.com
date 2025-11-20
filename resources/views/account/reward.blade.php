<form method="POST" action="">
  <!-- Win -->
  @csrf
  <label for="win">Win:</label>
  <select id="win" name="win">
    <option value="3">BigBang</option>
    <option value="4">Dragon</option>
  </select>
  <br><br>

  <!-- Win Point -->
  <label for="win_point">Win Point:</label>
  <input type="number" id="win_point" name="win_point">
  <br><br>

  <!-- Lose Point -->
  <label for="lose_point">Lose Point:</label>
  <input type="number" id="lose_point" name="lose_point">
  <br><br>

  <!-- Top -->
  <label for="top">Top:</label>
  <input type="text" id="top" name="top">
  <br><br>

  <!-- Support -->
  <label for="support">Support:</label>
  <input type="text" id="support" name="support">
  <br><br>

  <button type="submit">Submit</button>
</form>
