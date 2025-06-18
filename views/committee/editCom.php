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
            <a href="?c=committee&m=eventCommittee&id=<?= $event_id ?>" class="btn btn-secondary btn-sm">
                Kembali
            </a>
        </div>

        <form method="POST" action="?c=committee&m=updateCommittee&event_id=<?= $event_id ?>&committee_id=<?= $committee->committee_id ?>" class="event-form">
            <input type="hidden" name="committee_id" value="<?= $committee->committee_id ?>">

            <div class="form-group">
                <label for="name">Nama Panitia</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($committee->name) ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Jabatan</label>
                <input type="text" id="role" name="role" value="<?= htmlspecialchars($committee->role) ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Nomor Telepon</label>
                <input type="text" id="contact" name="contact" onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars($committee->contact) ?>" required>
            </div>

            <button type="submit" class="btn-submit">Perbarui</button>
        </form>
    </div>
</section>

<script src="src/js/committee.js"></script>
