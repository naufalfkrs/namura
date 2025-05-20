<section id="home" class="home">
    <div class="home-content">
        <div class="home-photo">
            <img src="src/img/bg3.png" alt="Foto Profil">
        </div>
        <div class="home-text">
            <h1>Selamat Datang di Website Namura</h1>
        </div>
    </div>
</section>

<section id="bio" class="bio">
    <div class="bio-container">
        <div class="bio-photo">
            <img src="src/img/about.png" alt="Foto Profil">
        </div>
        <div class="bio-isi">
            <p>NAMURA lahir dari kebutuhan akan solusi manajemen event yang lebih efektif dan efisien. Kami memahami bahwa mengatur sebuah event bisa menjadi tantangan besar, mulai dari koordinasi panitia, mencari sponsor, mengelola peserta, hingga menjual tiket. Oleh karena itu, kami menghadirkan NAMURA sebagai platform yang menghubungkan semua aspek tersebut dalam satu sistem terpadu. Kami percaya bahwa teknologi dapat menjadi alat yang kuat untuk menciptakan event yang lebih profesional dan berkesan. Dengan fitur-fitur yang terus dikembangkan, NAMURA berkomitmen untuk menjadi solusi terbaik bagi para penyelenggara event, membantu mereka menghemat waktu, mengoptimalkan sumber daya, dan meningkatkan kualitas acara yang mereka selenggarakan.</p>
        </div>
    </div>
</section>


<script>
    function toggleDropdown() {
        var menu = document.getElementById("dropdownMenu");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function(event) {
        var dropdown = document.querySelector(".user-dropdown");
        var menu = document.getElementById("dropdownMenu");

        if (!dropdown.contains(event.target)) {
            menu.style.display = "none";
        }
    });

    function toggleMenu() {
        var menu = document.querySelector(".menu");
        menu.classList.toggle("active");

    }

    window.addEventListener("scroll", function() {
        var navbar = document.querySelector(".navbar");
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
</script>