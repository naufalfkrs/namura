<?php
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
        $user = $userModel->login($email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = [
                'id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'foto' => $user->foto
            ];
            if ($user->role === 'admin' || $user->role === 'superadmin') {
                header("Location:?c=dashboard&m=indexAdmin");
            } else {
                header("Location:?c=dashboard&m=index");
            }
        } else {
            $this->loadView(
                "auth/login", 
                [
                    'title' => $title,
                    'error' => 'Login gagal, cek email/password'
                ],
                'auth'
            );
        }
    }

    public function register() {
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

        if ($result["isSuccess"]) {
            header("Location:?c=auth&m=login");
        } else {
            $this->loadView(
                "auth/register", 
                [
                    'title' => $title,
                    'error' => $result['info']
                ],
                'auth'
            );
        }
    }                               

    public function logout() {
        session_start();
        session_destroy();
        header("Location:?c=auth&m=login");
        exit();
    }
}