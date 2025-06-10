<div class="d-flex flex-column justify-content-start align-items-center px-3" style="min-height: 100vh; margin-bottom: 50px;">
    <div class="w-100 border rounded p-4 shadow" style="max-width: 900px; margin-top: 100px; background-color: #fff;">
        <h2 class="mb-4 text-center" style="color: #5c0099;"><?= htmlspecialchars($title) ?></h2>

        <a href="?c=user&m=createUser" class="btn btn-warning mb-3">+ Add</a>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col" class="text-center">Email</th>
                        <th scope="col" class="text-center">Role</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users->num_rows) :
                        $no = ($currentPage - 1) * 10 + 1;
                        while ($user = $users->fetch_object()) : ?>
                            <tr>
                                <td scope="row" class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($user->name) ?></td>
                                <td><?= htmlspecialchars($user->email) ?></td>
                                <td><?= htmlspecialchars($user->role) ?></td>
                                <td class="text-center">
                                    <?php if ($role === "superadmin") : ?>
                                        <a href="?c=user&m=editUser&id=<?= $user->user_id ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="?c=user&m=deleteUser&id=<?= $user->user_id ?>"
                                            class="btn btn-sm btn-outline-danger me-2"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    <?php elseif ($user->role === "superadmin") : ?>
                                        -
                                    <?php else : ?>
                                        <a href="?c=user&m=editUser&id=<?= $user->user_id ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="?c=user&m=deleteUser&id=<?= $user->user_id ?>"
                                            class="btn btn-sm btn-outline-danger me-2"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
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

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?c=user&m=index&page=<?= $currentPage - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="?c=user&m=index&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?c=user&m=index&page=<?= $currentPage + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        
        
    </div>
</div>