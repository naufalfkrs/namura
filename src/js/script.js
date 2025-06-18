function toggleDropdown() {
    var menu = document.getElementById("dropdownMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", function(event) {
    var dropdown = document.querySelector(".user-dropdown-namura");
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
    var navbar = document.querySelector(".navbar-namura");
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

// Untuk Fitur Sponsor
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol hapus AJAX
    document.body.addEventListener('click', function(e) {
        // Cek apakah yang diklik adalah tombol hapus dengan kelas .btn-hapus-ajax
        if (e.target && e.target.classList.contains('btn-hapus-ajax')) {
            e.preventDefault(); // Mencegah aksi default tombol

            const sponsorId = e.target.getAttribute('data-id');
            const eventId = e.target.getAttribute('data-eventid');
            const sponsorName = e.target.getAttribute('data-name');

            if (confirm(`Apakah Anda yakin ingin menghapus sponsor "${sponsorName}"?`)) {
                fetch(`?c=sponsor&m=ajaxDelete&id=${sponsorId}&event_id=${eventId}`, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        e.target.closest('tr').remove();
                        alert(data.message);
                    } else {
                        let errorMessage = 'Error: ' + data.message;
                        if (data.db_error && data.db_error.length > 0) {
                            errorMessage += '\n\nDetail Teknis: ' + data.db_error;
                        }
                        if (data.attempted_id) {
                            errorMessage += '\n\nID yang Coba Dihapus: ' + data.attempted_id;
                        }
                        alert(errorMessage);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan koneksi.');
                });
            }
        }
    });
});