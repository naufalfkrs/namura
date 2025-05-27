<h2><?= $title ?></h2>
<?php if (isset($error)): ?>
  <div><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="?c=dashboard&m=insertStudent" method="post">
  <div>
    <label for="name">Name</label><br>
    <input type="text" name="name" id="name" required>
  </div><br>
  <div>
    <label for="nim">Nim</label><br>
    <input type="text" name="nim" id="nim" required>
  </div><br>
  <div>
    <label for="address">Address</label><br>
    <input type="text" name="address" id="address" required>
  </div><br>
  <button type="submit">Save</button>
</form>