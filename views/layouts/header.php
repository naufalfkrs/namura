<header>
    <nav class="navbar-namura">
        <div class="logo">
            <img src="src/img/logonav.png" alt="Foto Profil">
        </div>

        <ul class="menu" id="menu">
            <?php if($role === "admin" || $role === "superadmin") : ?>
                <li><a href="?c=dashboard&m=indexAdmin">Home</a></li>
                <li><a href="?c=user&m=index">Users</a></li>
                <li><a href="?c=committee&m=index">Committes</a></li>
                <li><a href="?c=participant&m=index">Participants</a></li>
                <li><a href="?c=event&m=index">Events</a></li>
                <li><a href="?c=ticket&m=index">Tickets</a></li>
                <li><a href="?c=feedback&m=index">Feedbacks</a></li>
                <li><a href="?c=sponsor&m=index">Sponsors</a></li>
            <?php else : ?>
                <li><a href="?c=dashboard&m=index">Home</a></li>
                <li><a href="?c=event&m=list">Events</a></li>
            <?php endif; ?>
        </ul>

        <div class="navbar-right-cluster">
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
        </div>
    </nav>

</header>