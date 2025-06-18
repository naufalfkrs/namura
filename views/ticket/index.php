<div class="container">
    <!-- Gunakan management-header untuk semua elemen sejajar -->
    <div class="management-header">
        <h2 class="management-title">Manajemen Tiket</h2>
    </div>

    <div class="tambah-wrapper">
        <a href="?c=ticket&m=create" class="btn-add-event">+ Tambah Tiket</a>
    </div>

    <!-- Alert untuk notifikasi -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'updated'): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>Berhasil!</strong> Tiket berhasil diupdate.
                <button type="button" class="custom-close" onclick="this.parentElement.style.display='none'" aria-label="Close">×</button>
            </div>
        <?php elseif ($_GET['status'] == 'created'): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>Berhasil!</strong> Tiket baru berhasil ditambahkan.
                <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['status'] == 'deleted'): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <strong>Berhasil!</strong> Tiket berhasil dihapus.
                <button type="button" class="custom-close" onclick="this.parentElement.style.display='none'" aria-label="Close">×</button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Bungkus table dengan table-container untuk scroll horizontal di mobile -->
    <div class="table-container">
        <table class="table table-bordered table-hover bg-white">
            <thead class="bg-gradient text-white" style="background: linear-gradient(to right, rgb(164, 80, 80), #f7b733);">
                <tr>
                    <th>ID</th>
                    <th>Event</th>
                    <th>Jenis Tiket</th>
                    <th>Harga</th>
                    <th>Kuota</th>
                    <th>Terjual</th>
                    <th>Sisa</th>
                    <th>Status</th>
                    <th>Terakhir Diupdate</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                    <?php
                        $sold = $ticket['tickets_sold'];
                        $quota = max(0, $ticket['quota']);
                        $remaining = max(0, $quota - $sold);

                        if ($quota > 0 && $sold >= 0) {
                            $percentage = round(($sold / $quota) * 100, 1);
                        } elseif ($sold > 0 && $quota == 0) {
                            $percentage = 100;
                        } else {
                            $percentage = 0;
                        }

                        if ($percentage >= 90) {
                            $statusClass = 'status-almost-full';
                            $statusText = 'Hampir Penuh';
                        } elseif ($percentage >= 50) {
                            $statusClass = 'status-half-full';
                            $statusText = 'Setengah Penuh';
                        } elseif ($sold > 0) {
                            $statusClass = 'status-available';
                            $statusText = 'Tersedia';
                        } else {
                            $statusClass = 'status-empty';
                            $statusText = 'Belum Terjual';
                        }
                    ?>
                    <tr>
                        <td><?= $ticket['ticket_id'] ?></td>
                        <td><?= $ticket['event_title'] ?></td>
                        <td>
                            <span class="ticket-type-badge <?= strtolower($ticket['type']) ?>">
                                <?= $ticket['type'] ?>
                            </span>
                        </td>
                        <td>Rp<?= number_format($ticket['price'], 0, ',', '.') ?></td>
                        <td><?= $ticket['quota'] ?></td>
                        <td>
                            <strong><?= $sold ?></strong>
                            <small class="text-muted">(<?= $percentage ?>%)</small>
                        </td>
                        <td><?= $remaining ?></td>
                        <td>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= $statusText ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($ticket['created_at'])) ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn btn-info btn-detail" data-id="<?= $ticket['ticket_id'] ?>">Lihat Detail</button>
                                <a href="index.php?c=ticket&m=edit&id=<?= $ticket['ticket_id'] ?>" class="btn btn-primary">Edit</a>
                                <a href="index.php?c=ticket&m=delete&id=<?= $ticket['ticket_id'] ?>" class="btn btn-danger" onclick="return confirm('Hapus tiket ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div id="ticket-detail-modal" class="modal">
    <div class="modal-content">
        <link rel="stylesheet" href="src/css/ticket.css">
        <span class="close-modal">&times;</span>
        <h4>Detail Tiket</h4>
        <div id="ticket-detail-content"></div>
    </div>
</div>

<script src="src/js/ticket.js"></script>
