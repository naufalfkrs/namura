<section id="event" class="event" style="padding-top: 107px;">
    <div class="event-container">
        <h2><?= $title ?></h2>
        <a href="?c=event&m=create" class="btn-add-event">+ Tambah Event</a>

        <table class="event-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= htmlspecialchars($event['location']) ?></td>
                            <td><?= $event['start_date'] ?> s.d <?= $event['end_date'] ?></td>
                            <td>
                                <a href="?c=event&m=edit&id=<?= $event['event_id'] ?>">Edit</a> |
                                <a href="?c=event&m=delete&id=<?= $event['event_id'] ?>" onclick="return confirm('Hapus event ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align: center;">Belum ada event.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>