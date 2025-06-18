<div class="container mt-5">
    <h2 class="mb-4 text-center">Tambah Tiket Baru</h2>
    <link rel="stylesheet" href="src/css/ticket.css">

    <form method="POST" action="index.php?c=ticket&m=store">
        <div class="form-group mb-3">
            <label>Event</label>
            <select name="event_id" class="form-control" required>
                <option value="">Pilih Event</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event->event_id ?>"><?= $event->title ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Jenis Tiket</label>
            <select name="type" class="form-control" required>
                <option value="">Pilih Jenis Tiket</option>
                <option value="VIP">VIP - Premium</option>
                <option value="Regular">Regular - Standar</option>
                <option value="Economy">Economy - Ekonomis</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label>Harga</label>
            <input
                type="number"
                name="price"
                class="form-control"
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
            <button type="submit" class="btn-update">Simpan</button>
            <a href="?c=ticket&m=index" class="btn-grey">Kembali</a>
        </div>
    </form>
</div>
