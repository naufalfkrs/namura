<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Manajemen Sponsor</h2>
            
            <p class="text-muted">Untuk Event: <strong><?= htmlspecialchars($event['title']) ?></strong></p>
        
        </div>
        
        <a href="?c=sponsor&m=create&event_id=<?= $event['event_id'] ?>" class="btn btn-primary">Tambah Sponsor Baru</a>
    
    </div>
    
    <a href="?c=sponsor&m=index" class="btn btn-secondary mb-4">&larr; Kembali ke Daftar Event</a>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col" style="width: 5%;">No</th>
                    <th scope="col" style="width: 15%;">Logo</th>
                    <th scope="col">Nama Sponsor</th>
                    <th scope="col">Kontribusi</th>
                    <th scope="col" style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sponsors)): ?>
                    <?php foreach ($sponsors as $index => $sponsor): ?>
                        <tr>
                            <td data-label="No"><?= $index + 1 ?></td>
                            <td data-label="Logo">
                                <?php if (!empty($sponsor['logo_url']) && file_exists($sponsor['logo_url'])): ?>
                                    <img src="<?= htmlspecialchars($sponsor['logo_url']) ?>" alt="Logo <?= htmlspecialchars($sponsor['name']) ?>">
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Nama Sponsor"><?= htmlspecialchars($sponsor['name']) ?></td>
                            <td data-label="Kontribusi"><?= nl2br(htmlspecialchars($sponsor['contribution'])) ?></td>
                            <td data-label="Aksi">
                                <a href="?c=sponsor&m=edit&id=<?= $sponsor['sponsor_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm btn-hapus-ajax"
                                        data-id="<?php echo $sponsor['sponsor_id']; ?>"
                                        data-eventid="<?php echo $sponsor['event_id']; ?>"
                                        data-name="<?php echo htmlspecialchars($sponsor['name']); ?>">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada sponsor untuk event ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>