<section class="event-detail">
  <div class="event-detail-box">
    <h2><?= htmlspecialchars($event['title']) ?></h2>

    <p><span class="label">📍 Lokasi:</span> <?= htmlspecialchars($event['location']) ?></p>
    <p><span class="label">📅 Tanggal Mulai:</span> <?= $event['start_date'] ?></p>
    <p><span class="label">📅 Tanggal Selesai:</span> <?= $event['end_date'] ?></p>

    <?php if (!empty($event['description'])): ?>
      <p><span class="label">📝 Deskripsi:</span></p>
      <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
    <?php endif; ?>

    <br>
    <a href="?c=dashboard&m=index" class="btn-detail">⬅ Kembali ke Dashboard</a>
  </div>
</section>