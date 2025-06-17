<?php if (isset($results) && $results->num_rows > 0): ?>
    <?php $no = 1; while($row = $results->fetch_object()): ?>
        <tr>
            <td data-label="No."><?= $no++ ?></td>
            <td data-label="User Name"><?= htmlspecialchars($row->name) ?></td>
            <td data-label="Event"><?= htmlspecialchars($row->title) ?></td>
            <td data-label="Status"><?= htmlspecialchars(ucfirst($row->status)) ?></td>
            <td data-label="Actions">
                <a href="?c=participant&m=edit&id=<?= $row->participant_id ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="?c=participant&m=delete&id=<?= $row->participant_id ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Apakah kamu yakin ingin menghapus ini ?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td data-label="No." colspan="5">No participants found.</td>
    </tr>
<?php endif; ?>
