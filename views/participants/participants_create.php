<link rel="stylesheet" href="src/css/style.css">
<div class="wrapper">
    <div class="container">
        <h2><?= htmlspecialchars($title) ?></h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="?c=participant&m=insert" method="post" autocomplete="off">
            <div class="form-group">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">-- Select User --</option>
                    <?php
                    $usedUserIds = [];
                    foreach ($users as $user):
                        if (!in_array($user->user_id, $usedUserIds)):
                            $usedUserIds[] = $user->user_id;
                    ?>
                        <option value="<?= $user->user_id ?>"><?= htmlspecialchars($user->name) ?></option>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="event_id">Event</label>
                <select name="event_id" id="event_id" class="form-control" required>
                    <option value="">-- Select Event --</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= $event->event_id ?>"><?= htmlspecialchars($event->title) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="registered">Registered</option>
                    <option value="attended">Attended</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save</button>
            <a href="?c=participant&m=index" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>