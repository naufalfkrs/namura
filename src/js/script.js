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