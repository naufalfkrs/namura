<?php
// untuk login, register, logout
// berkaitan dengan views/auth/*.php
// password saat register menggunakan password_hash
// password saat login menggunakan password_verify
class AuthController extends Controller {
  public function login() {
    session_start();
    if (isset($_SESSION['user'])) {
      header("Location:?c=dashboard&m=index");
      exit();
    }
    
    $this->loadView("auth/login", ['title' => 'Login'], "auth");
  }

  public function loginProcess() {
    session_start();

    $title = 'Login';

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = $this->loadModel("user");
    $user = $userModel->login($email, $password);

    if ($user) {
      $_SESSION['user'] = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role
      ];
      header("Location:?c=dashboard&m=index");
    } else {
      $this->loadView(
        "auth/login", 
        [
          'title' => $title,
          'error' => 'Login gagal, cek username/password'
        ],
        'auth'
      );
    }
  }

  public function register() {
    // todo: menampilkan halaman register
    // 1. baca session, jika sudah ada session, maka lempar ke dashboard
    // 2. jika belum, tampilkan halaman register. gunakan layout 'auth'
    session_start();
    if (isset($_SESSION['user'])) {
      header("Location:?c=dashboard&m=index");
      exit();
    }
    
    $this->loadView("auth/register", ['title' => 'Register'], "auth");
  }

  public function registerProcess() {
    $title = 'Register';

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = $this->loadModel("user");
    $result = $userModel->register($name, $email, $password);

    if ($result) {
      header("Location:?c=auth&m=login");
    } else {
        $this->loadView(
        "auth/register", 
        [
          'title' => $title,
          'error' => 'email sudah ada'
        ],
        'auth'
      );
    }
  }

  public function css() {
    $this->redirect("style");
  }
  public function css2() {
    $this->redirect("style2");
  }
  public function image() {
    $this->image();
  }

  public function logout() {
    session_start();
    session_destroy();
    header("Location:?c=auth&m=login");
    exit();
  }
}