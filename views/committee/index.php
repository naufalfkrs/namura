<div class="create_container">
    <h2><?= htmlspecialchars($title) ?></h2>
</div>

<section id="event" class="event">
    <div class="event-container">
        <table class="event-table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Tanggal Event</th>
                    <th>Panitia</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event->title) ?></td>
                            <td><?= htmlspecialchars($event->start_date) ?> s.d <?= htmlspecialchars($event->end_date) ?></td>
                            <td>
                                <a href="?c=committee&m=eventCommittee&id=<?= urlencode($event->event_id) ?>">
                                    Selengkapnya
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center;">Belum ada event.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
