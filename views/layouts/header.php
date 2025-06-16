<header>
    <nav class="navbar-namura">
        <div class="logo">
            <img src="src/img/logonav.png" alt="Foto Profil">
        </div>

        <ul class="menu" id="menu">
            <?php if($role === "admin" || $role === "superadmin") : ?>
                <li><a href="?c=dashboard&m=indexAdmin">Home</a></li>
                <li><a href="?c=user&m=index">Data User</a></li>
                <li><a href="?c=event&m=index">Manajemen Event</a></li>
                <li><a href="?c=feedback&m=index">Data Feedback</a></li>
            <?php else : ?>
                <li><a href="?c=dashboard&m=index">Home</a></li>
                <li><a href="?c=event&m=list">Event</a></li>
            <?php endif; ?>
        </ul>

        
        <div class="user-dropdown-namura">
            <div class="user-info-namura" onclick="toggleDropdown()">
                <h4><?= htmlspecialchars($username) ?? 'Aplikasi MVC'; ?><span class="arrow">&#9662;</span> <img src="<?= !empty($foto) ? htmlspecialchars($foto  ) : 'src/img/profile.png' ?>" alt="Profile Photo" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;"></h4>
                <!-- Panah ke bawah -->
            </div>
            <ul class="dropdown-menu-namura" id="dropdownMenu">
                <li><a href="?c=dashboard&m=profile">Profile</a></li>
                <li><a href="?c=auth&m=logout">Logout</a></li>
            </ul>
        </div>  

        <!-- Tombol Hamburger -->
        <div class="hamburger" onclick="toggleMenu('menu')">
            &#9776; <!-- Simbol hamburger -->
        </div>
    </nav>

</header>