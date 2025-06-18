<div class="create_container">
    <h2><?= htmlspecialchars($title) ?></h2>

    <?php if (isset($error)): ?>
        <div style="color: red"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="color: green"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <a href="?c=committee&m=createCommittee&id=<?= $event->event_id ?>" class="btn-add-event">
        + Tambah Panitia
    </a>
</div>

<section id="event" class="event">
    <div class="event-container">
        <div class="d-flex justify-content-start">
            <a href="?c=committee&m=index" class="btn btn-secondary btn-sm">
                Kembali
            </a>
        </div>

        <table class="event-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Nomor Telepon</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($committees)): ?>
                    <?php foreach ($committees as $committee): ?>
                        <tr>
                            <td><?= htmlspecialchars($committee->name) ?></td>
                            <td><?= htmlspecialchars($committee->role) ?></td>
                            <td><?= htmlspecialchars($committee->contact) ?></td>
                            <td>
                                <a href="?c=committee&m=editCommittee&event_id=<?= $event->event_id ?>&committee_id=<?= $committee->committee_id ?>">Edit</a> |
                                <a href="?c=committee&m=deleteCommittee&event_id=<?= $event->event_id ?>&committee_id=<?= $committee->committee_id ?>" onclick="return confirm('Hapus panitia ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada Panitia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>