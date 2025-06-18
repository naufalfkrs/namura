<div class="container mt-5">
    <h2 class="mb-4 text-center">Edit Tiket</h2>
    <link rel="stylesheet" href="src/css/ticket.css">

    <!-- Alert untuk notifikasi -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'no_changes'): ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <strong>Perhatian!</strong> Tidak ada perubahan yang dilakukan.
            Silakan ubah minimal satu field untuk melakukan update.
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    <?php endif; ?>

    <form method="POST" action="?c=ticket&m=update">
        <input type="hidden" name="ticket_id" value="<?= $ticket['ticket_id'] ?>">

        <div class="form-group mb-3">
            <label>ID Event</label>
            <select name="event_id" class="form-control" required>
                <option value="">Pilih Event</option>
                <?php foreach ($events as $event): ?>
                    <option
                        value="<?= $event->event_id ?>"
                        <?= ($event->event_id == $ticket['event_id']) ? 'selected' : '' ?>
                    >
                        <?= $event->title ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Jenis Tiket</label>
            <select name="type" class="form-control" required>
                <option value="">Pilih Jenis Tiket</option>
                <option value="VIP" <?= ($ticket['type'] == 'VIP') ? 'selected' : '' ?>>VIP - Premium</option>
                <option value="Regular" <?= ($ticket['type'] == 'Regular') ? 'selected' : '' ?>>Regular - Standar</option>
                <option value="Economy" <?= ($ticket['type'] == 'Economy') ? 'selected' : '' ?>>Economy - Ekonomis</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Harga</label>
            <input
                type="number"
                name="price"
                class="form-control"
                value="<?= $ticket['price'] ?>"
                min="10000"
                required
                placeholder="Minimal Rp 10.000"
            >
            <small class="text-muted">
                Harga tidak boleh 0 atau minus, minimal Rp 10.000
            </small>
        </div>

        <div class="form-group mb-3">
            <label>Kuota</label>
            <input
                type="number"
                name="quota"
                class="form-control"
                value="<?= $ticket['quota'] ?>"
                min="1"
                max="10000"
                required
                placeholder="Minimal 1 tiket"
            >
            <small class="text-muted">
                Kuota tidak boleh 0 atau minus, minimal 1 tiket, maksimal 10.000 tiket
            </small>
        </div>

        <!-- Gunakan form-actions class untuk tombol -->
        <div class="form-actions">
            <button type="submit" class="btn-update">Update</button>
            <a href="?c=ticket&m=index" class="btn-grey">Kembali</a>
        </div>
    </form>
</div>
