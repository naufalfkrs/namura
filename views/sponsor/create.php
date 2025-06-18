<div class="container mt-5">
    <h2>Tambah Sponsor Baru</h2>
    
    <p class="text-muted">Untuk Event: <strong><?= htmlspecialchars($event['title']) ?></strong></p>

    <form action="?c=sponsor&m=store" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Nama Sponsor</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo Sponsor</label>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            <div class="form-text">Format yang diizinkan: JPG, PNG, GIF.</div>
        </div>

        <div class="mb-3">
            <label for="contribution" class="form-label">Bentuk Kontribusi</label>
            <textarea class="form-control" id="contribution" name="contribution" rows="4"></textarea>
            <div class="form-text">Jelaskan bentuk kontribusi dari sponsor, misal: 'Dana tunai Rp 10.000.000', 'Penyediaan konsumsi', dll.</div>
        </div>

        <a href="?c=sponsor&m=manage&event_id=<?= $event['event_id'] ?>" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Sponsor</button>
    </form>
</div>