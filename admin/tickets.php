<?php
require '../config.php';          // berisi $pdo
require '../auth_admin.php';      // pengecekan role

$event_id = (int)($_GET['event_id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM ticket_types WHERE event_id = ?");
$stmt->execute([$event_id]);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Manajemen Tiket – Event #<?= $event_id ?></h2>
<a href="ticket_form.php?event_id=<?= $event_id ?>" class="btn">Tambah Tiket</a>
<table>
  <thead>
    <tr><th>Nama</th><th>Harga</th><th>Quota</th><th>Terjual</th><th>Aksi</th></tr>
  </thead>
  <tbody>
    <?php foreach ($tickets as $t): ?>
      <tr>
        <td><?= htmlspecialchars($t['name']) ?></td>
        <td>Rp<?= number_format($t['price'],0,',','.') ?></td>
        <td><?= $t['quota'] ?></td>
        <td><?= $t['sold'] ?></td>
        <td>
          <a href="ticket_form.php?event_id=<?= $event_id ?>&ticket_type_id=<?= $t['ticket_type_id'] ?>">Edit</a>
          |
          <a href="ticket_delete.php?event_id=<?= $event_id ?>&ticket_type_id=<?= $t['ticket_type_id'] ?>"
             onclick="return confirm('Hapus tiket ini?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
