<div class="container" id="login-container">
    <h2><?= $title ?></h2>
    <?php if (isset($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form action="?c=auth&m=loginProcess" method="post">
        <label for="email-username">Email</label>
        <input type="email" name="email" id="email-username" placeholder="Masukkan Email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Masukkan Password" required>

        <button type="submit">Login</button>
        <div class="links">
            <a href="#">Lupa Password?</a>
            <a href="?c=auth&m=register">Belum punya akun? Daftar sekarang</a>
        </div>
    </form>
</div>