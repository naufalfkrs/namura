<div class="d-flex vh-100">
    <!-- Kolom kiri: foto profil -->
    <div class="w-50 overflow-hidden d-none d-lg-block">
        <img src="src/img/bg.avif" alt="Profile Photo" class="h-100 w-100 object-fit-cover" />
    </div>

    <!-- Kolom kanan: konten -->
    <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-start pt-5 mt-n5 px-5">
        <h2 class="mb-4 mt-5 text-center w-100"><?= htmlspecialchars($title) ?></h2>

        <div class="bg-white shadow-lg rounded p-4 w-100" style="min-width:300px; max-width:600px;">
            <div class="d-flex justify-content-center mb-4">
                <img src="<?= !empty($profiles->foto) ? htmlspecialchars($profiles->foto) : 'src/img/profile.png' ?>" alt="Profile Photo" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form enctype="multipart/form-data" action="?c=dashboard&m=updateProfile" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($profiles->user_id) ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="<?= htmlspecialchars($profiles->name) ?>"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="<?= htmlspecialchars($profiles->email) ?>"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Upload Foto</label>
                    <input
                        type="file"
                        name="foto"
                        id="foto"
                        class="form-control">
                </div>

                <button type="submit" class="btn btn-warning w-100">Save</button>
            </form>
        </div>

    </div>
</div>