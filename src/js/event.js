document.addEventListener('DOMContentLoaded', function () {
  // ===== TAMPILKAN MODAL DETAIL EVENT =====
  document.querySelectorAll('.btn-detail').forEach((button) => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      const id = this.dataset.id;

      fetch(`?c=event&m=detailAjax&id=${id}`)
        .then((res) => {
          if (!res.ok) throw new Error('Gagal mengambil detail event.');
          return res.text();
        })
        .then((html) => {
          document.querySelector('#modal-body').innerHTML = html;
          document.querySelector('#modal-detail').style.display = 'block';
          document.querySelector('#modal-overlay').style.display = 'block';
          document.body.classList.add('modal-open');
        })
        .catch((error) => {
          console.error(error);
          alert('❌ Terjadi kesalahan saat memuat detail event.');
        });
    });
  });

  // ===== TUTUP MODAL =====
  const closeModal = () => {
    document.querySelector('#modal-detail').style.display = 'none';
    document.querySelector('#modal-overlay').style.display = 'none';
    document.body.classList.remove('modal-open');
  };

  document.querySelector('#modal-close')?.addEventListener('click', closeModal);
  document.querySelector('#modal-overlay')?.addEventListener('click', closeModal);
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  // ===== HAPUS EVENT =====
  document.querySelectorAll('.btn-delete').forEach((button) => {
    button.addEventListener('click', function (e) {
      e.preventDefault();
      const id = this.dataset.id;

      console.log('Delete button clicked, ID:', id); // Tambahkan log

      fetch(`?c=event&m=checkTicketing&id=${id}`)
        .then((res) => {
          console.log('Response:', res); // Log respons
          return res.json();
        })
        .then((data) => {
          console.log('Data:', data); // Log data
          if (data.isInTicketing) {
            alert('❌ Event sudah terdaftar di ticketing. Hapus event dari ticketing terlebih dahulu.');
          } else {
            if (confirm('❗ Apakah Anda yakin ingin menghapus event ini?')) {
              window.location.href = `?c=event&m=delete&id=${id}`;
            }
          }
        })
        .catch((error) => {
          console.error('Error:', error); // Log error
          alert('❌ Terjadi kesalahan saat memeriksa keterkaitan event.');
        });
    });
  });
});