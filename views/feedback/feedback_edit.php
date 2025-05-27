<div class="d-flex flex-column justify-content-center align-items-center vh-100 px-3">
    <div class="w-100" style="max-width: 500px; margin-top: 10px;">
        <a href="?c=feedback&m=index" class="btn btn-secondary btn-sm">
            Kembali
        </a>
    </div>
    <div class="w-100 border rounded p-4 shadow" style="max-width: 500px; background-color: #fff;">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="?c=feedback&m=updateFeedback" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($results->feedback_id) ?>">
            <div class="mb-3">
                <label for="event_id" class="form-label">Event</label>
                <select name="event_id" id="event_id" class="form-control" required>
                    <option value="">-- Pilih Event --</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= htmlspecialchars($event->event_id) ?>"
                            <?= ($event->event_id == $results->event_id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($event->title) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" name="rating" id="rating" class="form-control" value="<?= htmlspecialchars($results->rating) ?>" required>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <input type="text" name="comment" id="comment" class="form-control" value="<?= htmlspecialchars($results->comment) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Save
            </button>
        </form>
    </div>
</div>