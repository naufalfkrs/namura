<?php
// untuk model autentikasi
// berkaitan dengan login, register
class User extends Model {
  public function getByName($email) {
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $this->dbconn->query($sql);
    return $result->fetch_object();
  }

  public function create() {
    // todo: menambah user
    // 1. tambahkan parameter nama dan password
    // 2. lakukan hashing terhadap password
    // 3. masukkan data user ke dalam tabel users
    // 4. kembalikan hasil dari querynya
  }

  public function login($email, $pass) {
      $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'";
      $result = $this->dbconn->query($sql);
      return $result;
  }

  public function register($user, $email, $pass) {
      $sql = "INSERT INTO users (name, email, password) VALUES ('$user', '$email', '$pass')";
      try {
          $this->dbconn->query($sql);
          $result = array("isSuccess"=>true);
      } catch (mysqli_sql_exception $e) {
          $result = array("isSuccess"=>false, "info"=>"Duplikasi pada Username");
      }
      return $result;
  }
}