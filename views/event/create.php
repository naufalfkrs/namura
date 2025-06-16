<section class="event-form-section">
  <div class="event-form-container">
    <!-- ✅ ALERT DITAMPILKAN DI SINI -->
    <?php if (!empty($_SESSION['error_message'])) : ?>
      <div style="color: red; font-weight: bold; margin-bottom: 10px;">
        <?= $_SESSION['error_message'];
        unset($_SESSION['error_message']); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])) : ?>
      <div style="color: green; font-weight: bold; margin-bottom: 10px;">
        <?= $_SESSION['success_message'];
        unset($_SESSION['success_message']); ?>
      </div>
    <?php endif; ?>

    <h2>Tambah Event</h2>

    <form id="form-create" method="POST" action="?c=event&m=store" class="event-form">
      <div class="form-group">
        <label for="title">Judul</label>
        <input type="text" id="title" name="title" value="<?= isset($old['title']) ? htmlspecialchars($old['title']) : '' ?>" required>
      </div>

      <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="4" required><?= isset($old['description']) ? htmlspecialchars($old['description']) : '' ?></textarea>
      </div>

      <div class="form-group">
        <label for="location">Lokasi</label>
        <input type="text" name="location" id="location" placeholder="Contoh: Malang (bisa kosong jika belum ditentukan)" value="<?= isset($old['location']) ? htmlspecialchars($old['location']) : '' ?>">
      </div>

      <div class="form-group">
        <label for="start_date">Tanggal Mulai</label>
        <input type="date" id="start_date" name="start_date" required value="<?= isset($old['start_date']) ? htmlspecialchars($old['start_date']) : '' ?>" required>
      </div>

      <div class="form-group">
        <label for="end_date">Tanggal Selesai</label>
        <input type="date" id="end_date" name="end_date" required value="<?= isset($old['end_date']) ? htmlspecialchars($old['end_date']) : '' ?>" required>
      </div>

      <button type="submit" class="btn-submit">Simpan</button>
      <a href="?c=event&m=index" class="btn-back">Kembali ke Daftar Event</a>
    </form>
  </div>
</section>

<script>
  // ✅ Validasi tanggal sebelum submit
  document.getElementById('form-create').addEventListener('submit', function(e) {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);

    if (startDate >= endDate) {
      alert('❌ Tanggal selesai harus lebih besar dari tanggal mulai.');
      e.preventDefault();
    }
  });
</script>

<!-- ✅ TAMPILKAN ALERT POPUP JIKA ADA PESAN -->
<?php if (!empty($_SESSION['error_message_popup'])) : ?>
  <script>
    alert("<?= $_SESSION['error_message_popup']; ?>");
  </script>
<?php unset($_SESSION['error_message_popup']);
endif; ?>

<?php if (!empty($_SESSION['success_message_popup'])) : ?>
  <script>
    alert("<?= $_SESSION['success_message_popup']; ?>");
  </script>
<?php unset($_SESSION['success_message_popup']);
endif; ?>