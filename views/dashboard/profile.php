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
            <ul class="list-unstyled mb-0">
            <li><strong>Name :</strong> <?= htmlspecialchars($profiles->name) ?></li><br>
            <li><strong>Email :</strong> <?= htmlspecialchars($profiles->email) ?></li><br>
            <li><strong>Role :</strong> <?= htmlspecialchars($profiles->role) ?></li>
            </ul>

            <div class="d-flex justify-content-center mt-4">
                <a href="?c=dashboard&m=editProfile&id=<?= $profiles->user_id ?>" class="btn btn-warning px-4">
                Edit Profile
                </a>
            </div>
        </div>

    </div>
</div>