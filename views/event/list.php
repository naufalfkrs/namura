<section class="dashboard-events-wrapper">
    <div class="dashboard-events">
        <h2 class="event-section-title">Daftar Semua Event</h2>

        <?php if (!empty($events)) : ?>
            <div class="event-card-grid">
                <?php foreach ($events as $event) : ?>
                    <div class="event-card">
                        <h3 class="event-title"><?= htmlspecialchars($event['title']) ?></h3>
                        <p><span class="label">📍 Lokasi:</span> <?= !empty($event['location']) ? htmlspecialchars($event['location']) : 'Belum ditentukan' ?></p>
                        <p><span class="label">📅 Tanggal Mulai:</span> <?= $event['start_date'] ?></p>
                        <p><span class="label">📅 Tanggal Selesai:</span> <?= $event['end_date'] ?></p>
                        <?php if (!empty($event['description'])) : ?>
                            <p>
                                <span class="label">📝 Deskripsi :</span>
                                <?= nl2br(htmlspecialchars(substr($event['description'], 0, 50))) ?>...
                            </p>
                        <?php endif; ?>
                        <div class="d-flex justify-content-center gap-2 w-100">   
                            <button class="btn btn-warning w-50" data-id="<?= $event['event_id'] ?>">Selengkapnya</button>
                             <a href="?c=feedback&m=createFeedbackUser&event_id=<?= $event['event_id'] ?>" class="btn btn-primary w-50">
                                Add Feedback
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p style="text-align:center;">Belum ada event yang tersedia.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Modal & Overlay -->
<div id="modal-overlay" class="modal-overlay" style="display: none;"></div>
<div id="modal-detail" class="modal-box" style="display: none;">
    <button id="modal-close" class="modal-close">x</button>
    <div id="modal-body"></div>
</div>

<!-- JS -->
<script src="src/js/event.js"></script>