<?php
// untuk dashboard (dashboard utama, profil, settings, dll)
// untuk CRUD data siswa
// berkaitan dengan views/dashboard/*.php
class DashboardController extends Controller {
  public function __construct() {
    session_start();
    if (!isset($_SESSION['user'])) {
      header("Location:?c=auth&m=login");
      exit();
    }
  }
  
  public function index() { 
    $title = 'Dashboard';

    $this->loadView(
      "dashboard/index",
      [
        'title' => $title,
        'username' => $_SESSION['user']
      ],
      'main'
    );
  }

  public function profile() {
    // todo: menampilkan halaman profile pengguna yang login
    // 1. tampilkan halaman profile. gunakan layout 'main'
    // 2. gunakan data session untuk menampilkan profile pengguna
  }

  public function getAllStudents() {
    // todo: menampilkan semua data siswa
    // 1. ambil data seluruh siswa dari database
    // 2. tampilkan halaman students (index). gunakan layout 'main'
  }

  public function createStudent() {
    // todo: menampilkan halaman tambah siswa
    // 1. tampilkan halaman tambah siswa (create). gunakan layout 'main'
  }

  public function insertStudent() {
    // todo: menambahkan data siswa
    // 1. baca data yang dikirim dari form
    // 2. tambah data siswa ke dalam database.
    //    - jika sukses tampilkan halaman seluruh data siswa
    //    - jika gagal, tetap tampilkan halaman tambah siswa 
    //      dengan menampilkan pesan error
  }

  public function editStudent() {
    // todo: menampilkan halaman ubah data siswa
    // 1. baca data id yang dikirimkan melalui url 
    //    sesuai id siswa yang akan diubah
    // 2. ambil data siswa dari database berdasarkan id tersebut
    // 3. tampilkan halaman ubah data siswa (edit). gunakan layout 'main'.
    //    seluruh data siswa dengan id tersebut ditampilkan di form
  }

  public function updateStudent() {
    // todo: mengubah data siswa
    // 1. baca data yang dikirim dari form
    // 2. ubah data siswa ke dalam database.
    //    - jika sukses tampilkan halaman seluruh data siswa
    //    - jika gagal, tetap tampilkan halaman ubah data siswa 
    //      dengan menampilkan pesan error
  }

  public function deleteStudent() {
    // todo: menghapus data siswa
    // 1. baca data id yang dikirimkan melalui url 
    //    sesuai id siswa yang akan dihapus
    // 2. hapus data siswa yang ada di dalam database.
    //    - jika sukses tampilkan halaman seluruh data siswa
  }
}