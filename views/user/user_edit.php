<h2><?= htmlspecialchars($title) ?></h2>
<?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="?c=user&m=updateUser" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($users->user_id) ?>">
    <div>
        <label for="name">Name</label><br>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($users->name) ?>" required>
    </div><br>
    <div>
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($users->email) ?>" required>
    </div><br>
    <div>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password" value="<?= htmlspecialchars($users->password) ?>" required>
    </div><br>
    <div>
        <label for="role">Role</label><br>
        <select name="role" id="role" required>
            <option value="">-- Pilih Role --</option>
            <?php if($role === "superadmin") : ?>
                <option value="superadmin" <?= $users->role === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
            <?php endif; ?>
            <option value="admin" <?= $users->role === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="panitia" <?= $users->role === 'panitia' ? 'selected' : '' ?>>Panitia</option>
            <option value="peserta" <?= $users->role === 'peserta' ? 'selected' : '' ?>>Peserta</option>
        </select>
    </div><br>
    <button type="submit">Save</button>
</form>