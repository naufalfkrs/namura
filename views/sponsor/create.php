<section class="container">
    <h2>Tambah Sponsor Baru</h2>

    <form action="?c=sponsor&m=store" method="POST">
        <div style="margin-bottom: 15px;">
            <label for="name">Nama Sponsor</label><br>
            <input type="text" name="name" id="name" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="logo_url">Logo URL</label><br>
            <input type="url" name="logo_url" id="logo_url" placeholder="https://example.com/logo.png" style="width: 100%;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="contribution">Kontribusi</label><br>
            <textarea name="contribution" id="contribution" rows="4" style="width: 100%;"></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="event_id">Event</label><br>
            <select name="event_id" id="event_id" required style="width: 100%;">
                <option value="">-- Pilih Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['event_id'] ?>"><?= htmlspecialchars($event['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="?c=sponsor&m=index" class="btn btn-secondary">Batal</a>
    </form>
</section>