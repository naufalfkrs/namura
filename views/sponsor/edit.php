<div class="container mt-5">
    <h2>Edit Sponsor: <?= htmlspecialchars($sponsor->name) ?></h2>

    <form action="?c=sponsor&m=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="sponsor_id" value="<?= $sponsor->sponsor_id ?>">
        <input type="hidden" name="event_id" value="<?= $sponsor->event_id ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Nama Sponsor</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($sponsor->name) ?>" required>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo Sponsor</label>
            <br>
            <?php if (!empty($sponsor->logo_url) && file_exists($sponsor->logo_url)): ?>
                <img src="<?= htmlspecialchars($sponsor->logo_url) ?>" alt="Logo saat ini" class="mb-2" style="max-width: 200px;">
                <br>
            <?php endif; ?>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            <div class="form-text">Kosongkan jika tidak ingin mengubah logo.</div>
        </div>

        <div class="mb-3">
            <label for="contribution" class="form-label">Bentuk Kontribusi</label>
            <textarea class="form-control" id="contribution" name="contribution" rows="4"><?= htmlspecialchars($sponsor->contribution) ?></textarea>
        </div>

        <a href="?c=sponsor&m=index&event_id=<?= $sponsor->event_id ?>" class="btn btn-secondary">Batal</a>
        <button type="submit" class="btn btn-primary">Update Sponsor</button>
    </form>
</div>