<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-100 border rounded p-4 shadow" style="max-width: 900px; background-color: #fff;">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h2>

        <a href="?c=feedback&m=createFeedback" class="btn btn-success mb-3">Tambah di sini</a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">User</th>
                        <th scope="col">Event Name</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results->num_rows) :
                        $no = 1;
                        while ($result = $results->fetch_object()) : ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td><?= htmlspecialchars($result->name) ?></td>
                                <td><?= htmlspecialchars($result->title) ?></td>
                                <td><?= htmlspecialchars($result->rating) ?></td>
                                <td><?= htmlspecialchars($result->comment) ?></td>
                                <td>
                                    <a href="?c=feedback&m=editfeedback&id=<?= $result->feedback_id ?>" class="btn btn-sm btn-primary me-2">Edit</a>
                                    <a href="?c=feedback&m=deletefeedback&id=<?= $result->feedback_id ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus feedback ini?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data feedback</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>