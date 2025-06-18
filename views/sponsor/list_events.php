<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manajemen Sponsor</h2>
    </div>
    <p class="text-muted">Pilih event di bawah ini untuk mulai mengelola data sponsornya.</p>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col" style="width: 5%;">No</th>
                    <th scope="col">Judul Event</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col" style="width: 20%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $index => $event): ?>
                        <tr>
                            <td data-label="No"><?= $index + 1 ?></td>
                            <td data-label="Judul Event"><?= htmlspecialchars($event['title']) ?></td>
                            <td data-label="Lokasi"><?= !empty($event['location']) ? htmlspecialchars($event['location']) : 'Belum ditentukan' ?></td>
                            <td data-label="Tanggal"><?= date('d M Y', strtotime($event['start_date'])) ?></td>
                            <td data-label="Aksi">
                                <a href="?c=sponsor&m=manage&event_id=<?= $event['event_id'] ?>" class="btn btn-primary">
                                    Kelola Sponsor
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada event yang dibuat. Silakan buat event terlebih dahulu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>