<section class="event-form-section">
    <div class="event-form-container">
        <h2>Tambah Event</h2>
        <form method="POST" action="?c=event&m=store" class="event-form">
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="location">Lokasi</label>
                <input type="text" id="location" name="location">
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date">
            </div>

            <div class="form-group">
                <label for="end_date">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date">
            </div>

            <button type="submit" class="btn-submit">Simpan</button>
        </form>
    </div>
</section>
