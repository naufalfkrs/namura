<div class="ticket-form-container">
    <link rel="stylesheet" href="src/css/ticket.css">

    <h2>Form Pemesanan Tiket</h2>

    <!-- Alert untuk notifikasi -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'order_failed'): ?>
            <div class="alert alert-danger" role="alert">
                <strong>Gagal!</strong> Pemesanan gagal dilakukan.
                <button type="button" class="custom-close" onclick="this.parentElement.style.display='none'" aria-label="Close">×</button>
            </div>
        <?php elseif ($_GET['status'] == 'overquote'): ?>
            <div class="alert alert-warning" role="alert">
                <span>Jumlah tiket yang dipesan melebihi kuota tersedia.</span>
                <button type="button" class="custom-close" onclick="this.parentElement.style.display='none'" aria-label="Close">×</button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (count($tickets) > 0): ?>
        <form action="?c=ticketUser&m=submitOrder" method="POST">
            <!-- Kirim data penting -->
            <input type="hidden" name="event_id" value="<?= $event_id ?>">
            <input type="hidden" name="user_id" value="<?= $user_id ?>"> <!-- 🟣 ini baris penting -->

            <!-- Pilihan tiket -->
            <label for="ticket_id">Pilih Tiket:</label>
            <select name="ticket_id" class="form-select" required>
                <?php foreach ($tickets as $ticket): ?>
                    <option value="<?= $ticket['ticket_id'] ?>">
                        <?= $ticket['type'] ?> - Rp<?= number_format($ticket['price'], 0, ',', '.') ?> (Kuota: <?= $ticket['quota'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Jumlah -->
            <label for="jumlah" class="mt-3">Jumlah Tiket:</label>
            <input type="number" name="jumlah" min="1" class="form-control" required>

            <!-- Tombol submit -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                <a href="index.php" class="btn btn-grey">Kembali</a>
            </div>
        </form>
    <?php else: ?>
        <p class="text-muted">Maaf, belum ada tiket tersedia untuk event ini.</p>
    <?php endif; ?>
</div>

<!-- Modal -->
<div id="order-success-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <link rel="stylesheet" href="src/css/ticket.css">
        <span class="close-modal" onclick="document.getElementById('order-success-modal').style.display='none'">&times;</span>
        <h4>🎉 Tiket Berhasil Dipesan!</h4>
        <div id="order-details"></div>
    </div>
</div>

<script src="src/js/ticket.js"></script>
