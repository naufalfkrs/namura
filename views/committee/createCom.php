<div class="create_container">
    <h2><?= htmlspecialchars($title) ?></h2>
    <?php if (isset($error)): ?>
        <div style="color: red"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div style="color: green"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
</div>

<section class="event-form-section">
    <div class="event-form-container">
        <div class="d-flex justify-content-start">
            <a href="?c=committee&m=index" class="btn btn-secondary btn-sm">
                Kembali
            </a>
        </div>

        <form method="POST" action="?c=committee&m=insertCommittee&id=<?= $event_id ?>" class="event-form">
            <div class="form-group">
                <label for="name">Nama Panitia</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="role">Jabatan</label>
                <input type="text" id="role" name="role" rows="4" required></input>
            </div>

            <div class="form-group">
                <label for="contact">Nomor Telepon</label>
                <input type="text" id="contact" name="contact" onkeypress="return isNumberKey(event)" required>
            </div>

            <button type="submit" class="btn-submit">Tambah</button>
        </form>
    </div>
</section>

<script src="src/js/committee.js"></script>