
    <div class="container" id="register-container">
        <h2><?= $title ?></h2>
        <?php if (isset($error)): ?>
          <div><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="?c=auth&m=registerProcess" method="post">
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan Email" required>
            
            <label for="username">Username</label>
            <input type="text" id="name" name="name" placeholder="Masukkan Username" required>
            
            <label for="password-register">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
            
            <button type="submit">Daftar</button>
            <div class="links">
                <a href="?c=auth&m=login">Sudah punya akun? Login di sini</a>
            </div>
        </form>
    </div>

