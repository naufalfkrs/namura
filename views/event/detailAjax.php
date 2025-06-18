<div class="font-purple">
  <h3><?= htmlspecialchars($event['title']) ?></h3>
  <p><strong>📍 Lokasi:</strong> <?= !empty($event['location']) ? htmlspecialchars($event['location']) : 'Belum ditentukan' ?></p>
  <p><strong>📅 Tanggal Mulai:</strong> <?= $event['start_date'] ?></p>
  <p><strong>📅 Tanggal Selesai:</strong> <?= $event['end_date'] ?></p>
  <p><strong>📝 Deskripsi:</strong><br><?= nl2br(htmlspecialchars($event['description'])) ?></p>
  <?php if($role !== 'admin' || $role !== 'superadmin') : ?>
    <a href="?c=ticketUser&m=form&id=<?= $event['event_id'] ?>" class="btn btn-primary">
      Pesan Tiket
    </a>
  <?php endif; ?> 
</div>