<div class="d-flex flex-column justify-content-start align-items-center px-3" style="min-height: 100vh; margin-bottom: 50px;">
    <div class="w-100" style="max-width: 650px; margin-top: 50px;">
        <a href="?c=user&m=index" class="mt-4 btn btn-outline-warning btn-lg">
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

        <form action="?c=user&m=insertStudent" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <?php if ($role === "superadmin") : ?>
                        <option value="superadmin">Superadmin</option>
                    <?php endif; ?>
                    <option value="admin">Admin</option>
                    <option value="panitia">Panitia</option>
                    <option value="peserta">Peserta</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning w-100">
                Save
            </button>
        </form>
    </div>
</div>