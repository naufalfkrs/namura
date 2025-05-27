<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-100 border rounded p-4 shadow" style="max-width: 900px; background-color: #fff;">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($title) ?></h2>

        <a href="?c=user&m=createUser" class="btn btn-success mb-3">Daftar di sini</a>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users->num_rows) :
                        $no = 1;
                        while ($user = $users->fetch_object()) : ?>
                            <tr>
                                <th scope="row"><?= $no++ ?></th>
                                <td><?= htmlspecialchars($user->name) ?></td>
                                <td><?= htmlspecialchars($user->email) ?></td>
                                <td><?= htmlspecialchars($user->role) ?></td>
                                <td>
                                    <a href="?c=user&m=editUser&id=<?= $user->user_id ?>" class="btn btn-sm btn-primary me-2">Edit</a>
                                    <a href="?c=user&m=deleteUser&id=<?= $user->user_id ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data user</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>