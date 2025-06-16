<section class="event-form-section">
    <div class="event-form-container">
        <h2>Edit Event</h2>
        <form id="form-edit" method="POST" action="?c=event&m=update" class="event-form">
            <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['event_id']) ?>">

            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="location">Lokasi</label>
                <input type="text" name="location" id="location" value="<?= htmlspecialchars($event['location']) ?>" placeholder="Contoh: Malang (bisa kosong jika belum ditentukan)">
            </div>

            <div class="form-group">
                <label for="start_date">Tanggal Mulai</label>
                <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($event['start_date']) ?>" required>
            </div>

            <div class="form-group">
                <label for="end_date">Tanggal Selesai</label>
                <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($event['end_date']) ?>" required>
            </div>

            <button type="submit" class="btn-submit">Update</button>
            <a href="?c=event&m=index" class="btn-back">Kembali ke Daftar Event</a>
        </form>
    </div>
</section>

<script>
    document.getElementById('form-edit').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah pengiriman form default

        const formData = new FormData(this);
        const startDate = new Date(formData.get('start_date'));
        const endDate = new Date(formData.get('end_date'));

        // Validasi tanggal
        if (startDate >= endDate) {
            alert('❌ Tanggal selesai harus lebih besar dari tanggal mulai.');
            return;
        }

        // Kirim data menggunakan AJAX
        fetch('?c=event&m=update', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert('✅ Event berhasil diperbarui!');
                    window.location.href = '?c=event&m=index'; // Redirect ke daftar event
                } else {
                    alert(`❌ ${result.message}`); // Menampilkan pesan error dari server
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan. Silakan coba lagi.');
            });
    });
</script>