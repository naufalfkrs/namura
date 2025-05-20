<header>
    <nav class="navbar">
        <div class="logo">
            <img src="src/img/logonav.png" alt="Foto Profil">
        </div>

        <ul class="menu" id="menu">
            <li><a href="#home">Home</a></li>
            <li><a href="#bio">About Us</a></li>
            <!-- <li><a class="logout" href="logout_process.php">Logout</a></li> -->
        </ul>

        <div class="user-dropdown">
            <div class="user-info" onclick="toggleDropdown()">
                <h4>Hi, <?= htmlspecialchars($username) ?? 'Aplikasi MVC'; ?> <span class="arrow">&#9662;</span></h4>
                <!-- Panah ke bawah -->
            </div>
            <ul class="dropdown-menu" id="dropdownMenu">
                <li><a href="?c=auth&m=logout">Logout</a></li>
            </ul>
        </div>  

        <!-- Tombol Hamburger -->
        <div class="hamburger" onclick="toggleMenu('menu')">
            &#9776; <!-- Simbol hamburger -->
        </div>
    </nav>

</header>