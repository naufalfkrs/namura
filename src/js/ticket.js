
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'ordered') {
        fetch('index.php?c=ticketUser&m=getLastOrder')
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const order = result.data;
                    document.getElementById('order-details').innerHTML = `
                        <p><strong>ID Tiket:</strong> ${order.ticket_id}</p>
                        <p><strong>Nama:</strong> ${order.user_name}</p>
                        <p><strong>Event:</strong> ${order.event_title}</p>
                        <p><strong>Jenis Tiket:</strong> ${order.ticket_type}</p>
                        <p><strong>Harga:</strong> Rp${Number(order.price).toLocaleString()}</p>
                        <p><strong>Tanggal:</strong> ${order.created_at}</p>
                    `;
                    document.getElementById('order-success-modal').style.display = 'flex';
                } else {
                    alert("Tidak ada pemesanan terakhir ditemukan.");
                }
            });
    }
});

document.querySelectorAll('.btn-detail').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;

        // ✔ Perbaikan: URL pakai string literal yang benar
        fetch(`index.php?c=ticket&m=detailAjax&id=${id}`)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const ticket = result.data;

                    // ✔ Perbaikan: isi innerHTML dibungkus backtick
                    document.getElementById('ticket-detail-content').innerHTML = `
                        <p><strong>ID Event:</strong> ${ticket.event_id}</p>
                        <p><strong>Jenis Tiket:</strong> ${ticket.type}</p>
                        <p><strong>Harga:</strong> Rp${Number(ticket.price).toLocaleString()}</p>
                        <p><strong>Kuota:</strong> ${ticket.quota}</p>
                    `;

                    // ✔ Tampilkan modal
                    document.getElementById('ticket-detail-modal').style.display = 'flex';
                } else {
                    alert(result.message);
                }
            })
            .catch(err => {
                console.error('Gagal fetch:', err);
                alert('Terjadi kesalahan saat mengambil detail tiket.');
            });
    });
});

// ✔ Tutup modal
document.querySelector('.close-modal').addEventListener('click', () => {
    document.getElementById('ticket-detail-modal').style.display = 'none';
});
