function loadFeedbacks() {
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newBody = doc.querySelector('#feedbackTableBody');
        const currentBody = document.querySelector('#feedbackTableBody');

        if (newBody && currentBody) {
            currentBody.innerHTML = newBody.innerHTML;
        }
    })
    .catch(error => {
        console.error('Gagal mengambil data feedback:', error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setInterval(loadFeedbacks, 1000); // update setiap 5 detik
});
