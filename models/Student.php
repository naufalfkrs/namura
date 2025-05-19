<?php
// untuk data siswa
// berkaitan dengan CRUD siswa
class Student extends Model {
  private $lastErrorCode;

  public function getAll() {
    // todo: menampilkan seluruh data siswa
    // 1. tampilkan seluruh data siswa
    // 2. kembalikan hasil dari querynya
  }

  public function getById() {
    // todo: menampilkan data siswa berdasarkan id
    // 1. tambahkan parameter id
    // 2. tampilkan data siswa berdasarkan id tersebut
    // 3. kembalikan hasil dari querynya cukup 1 baris saja
  }

  public function create() {
    // todo: menambahkan data siswa
    // 1. tambahkan parameter nama, nim, dan alamat
    // 2. tambahkan data siswa berdasarkan parameter tersebut
    // 3. jika data siswa unik (cek struktur tabel), 
    //    kembalikan hasil dari querynya
    // 4. jika data siswa ganda, isi lastErrorCode dengan kode errornya,
    //    kembalikan nilai false
    // NB: gunakan exception handling
  }

  public function update() {
    // todo: mengubah data siswa
    // 1. tambahkan parameter id, nama, nim, dan alamat
    // 2. ubah data siswa berdasarkan parameter tersebut
    // 3. jika data siswa unik (cek struktur tabel), 
    //    kembalikan hasil dari querynya
    // 4. jika data siswa ganda, isi lastErrorCode dengan kode errornya,
    //    kembalikan nilai false
    // NB: gunakan exception handling
  }

  public function delete() {
    // todo: menghapus data siswa
    // 1. tambahkan parameter id
    // 2. hapus data siswa berdasarkan parameter tersebut
    // 3. kembalikan hasil dari querynya
  }

  public function getLastErrorCode() {
    return $this->lastErrorCode;
  }
}