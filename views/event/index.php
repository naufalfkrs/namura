<section id="event" class="event">
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
                <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $event) : ?>
                        <tr>
                            <td><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= !empty($event['location']) ? htmlspecialchars($event['location']) : 'Belum ditentukan' ?></td>
                            <td><?= $event['start_date'] ?> s.d <?= $event['end_date'] ?></td>
                            <td>
                                <a href="?c=event&m=edit&id=<?= $event['event_id'] ?>">Edit</a> |
                                 <a href="#" class="btn-delete" data-id="<?= $event['event_id'] ?>">Delete</a>
                                

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada event.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php if (!empty($_SESSION['success_message_popup'])): ?>
<script>
    alert("<?= $_SESSION['success_message_popup']; ?>");
</script>
<?php unset($_SESSION['success_message_popup']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error_message_popup'])): ?>
<script>
    alert("<?= $_SESSION['error_message_popup']; ?>");
</script>
<?php unset($_SESSION['error_message_popup']); ?>
<?php endif; ?>

<script src="src/js/event.js"></script>