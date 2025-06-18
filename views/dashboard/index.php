<section id="home" class="home">
    <div class="home-content">
        <div class="home-photo">
            <img src="src/img/bg3.png" alt="Foto Profil">
        </div>
        <div class="home-text">
            <h1>Selamat Datang di Website Namura</h1>
        </div>
    </div>
</section>

<section id="bio" class="bio">
    <div class="bio-container">
        <div class="bio-photo">
            <img src="src/img/about.png" alt="Foto Profil">
        </div>
        <div class="bio-isi">
            <p>NAMURA lahir dari kebutuhan akan solusi manajemen event yang lebih efektif dan efisien. Kami memahami bahwa mengatur sebuah event bisa menjadi tantangan besar, mulai dari koordinasi panitia, mencari sponsor, mengelola peserta, hingga menjual tiket. Oleh karena itu, kami menghadirkan NAMURA sebagai platform yang menghubungkan semua aspek tersebut dalam satu sistem terpadu. Kami percaya bahwa teknologi dapat menjadi alat yang kuat untuk menciptakan event yang lebih profesional dan berkesan. Dengan fitur-fitur yang terus dikembangkan, NAMURA berkomitmen untuk menjadi solusi terbaik bagi para penyelenggara event, membantu mereka menghemat waktu, mengoptimalkan sumber daya, dan meningkatkan kualitas acara yang mereka selenggarakan.</p>
        </div>
    </div>
</section>

<section class="dashboard-events-wrapper">
    <div class="dashboard-events">
        <?php if($role !== 'admin' && $role !== 'superadmin') : ?>
            <h2 class="event-section-title">Daftar Semua Event</h2>
        <?php endif; ?>

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
        <?php elseif ($role == 'admin' || $role == 'superadmin') : ?>
           
        <?php else : ?>
            <p style="text-align:center;">Belum ada event yang tersedia.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Modal & Overlay -->
<div id="modal-overlay" class="modal-overlay" style="display: none;"></div>
<div id="modal-detail" class="modal-box" style="display: none;">
    <button id="modal-close" class="modal-close">×</button>
    <div id="modal-body"></div>
</div>

<!-- JS -->
<script src="src/js/event.js"></script>