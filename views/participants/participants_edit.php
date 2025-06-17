<link rel="stylesheet" href="src/css/style.css">
<div class="wrapper">
    <div class="container">
        <h2><?= htmlspecialchars($title) ?></h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="?c=participant&m=update" method="post" autocomplete="off">
            <input type="hidden" name="id" value="<?= $results->participant_id ?>">

            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">-- Select User --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user->user_id ?>"
                            <?= $user->user_id == $results->user_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="event_id">Event</label>
                <select name="event_id" id="event_id" class="form-control" required>
                    <option value="">-- Select Event --</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= $event->event_id ?>"
                            <?= $event->event_id == $results->event_id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($event->title) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="registered" <?= $results->status == 'registered' ? 'selected' : '' ?>>Registered</option>
                    <option value="attended" <?= $results->status == 'attended' ? 'selected' : '' ?>>Attended</option>
                    <option value="cancelled" <?= $results->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update</button>
            <a href="?c=participant&m=index" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
