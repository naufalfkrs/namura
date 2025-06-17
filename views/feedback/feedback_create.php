

<div class="d-flex flex-column justify-content-start align-items-center px-3" style="min-height: 100vh; margin-bottom: 50px;">
    <div class="w-100" style="max-width: 650px; margin-top: 50px;">
        <a href="?c=feedback&m=index" class="mt-4 btn btn-outline-warning btn-lg">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
    <div class="mt-4 w-100 border rounded p-4 shadow" style="max-width: 650px; background-color: #fff;">
        <h2 class="mb-4 text-center" style="color: #5c0099;"><?= htmlspecialchars($title) ?></h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="?c=feedback&m=insertFeedback" method="post">
            <div class="mb-3">
                <label for="event_id" class="form-label">Event</label>
                <select name="event_id" id="event_id" class="form-control" required>
                    <option value="">-- Pilih Event --</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= htmlspecialchars($event->event_id) ?>">
                            <?= htmlspecialchars($event->title) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" name="rating" id="rating" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <input type="text" name="comment" id="comment" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning w-100">
                Save
            </button>
        </form>
    </div>
</div>