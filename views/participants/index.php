<link rel="stylesheet" href="src/css/style.css">
<div class="wrapper">
    <div class="container">
        <h2><?= htmlspecialchars($title) ?></h2>

        <!-- Tombol Add & Refresh -->
        <a href="?c=participant&m=create" class="btn btn-success mb-3">Add Participant</a>
        <button id="refresh-btn" class="btn btn-primary mb-3">Refresh Data</button>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- TABEL AJAX TARGET -->
        <div id="participants-table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>User Name</th>
                        <th>Event</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results && $results->num_rows > 0): ?>
                        <?php $no = 1; while($row = $results->fetch_object()): ?>
                            <tr>
                                <td data-label="No."><?= $no++ ?></td>
                                <td data-label="User Name"><?= htmlspecialchars($row->name) ?></td>
                                <td data-label="Event"><?= htmlspecialchars($row->title) ?></td>
                                <td data-label="Status"><?= htmlspecialchars(ucfirst($row->status)) ?></td>
                                <td data-label="Actions">
                                    <a href="?c=participant&m=edit&id=<?= $row->participant_id ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?c=participant&m=delete&id=<?= $row->participant_id ?>" 
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah kamu yakin ingin menghapus ini ?');">
                                    Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5">No participants found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- File JavaScript lokal -->
<script src="src/js/participants.js"></script>

