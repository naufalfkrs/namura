<?php
class UserController extends Controller
{
    protected $username;
    protected $role;
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }

        if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['role'] !== 'superadmin') {
            header("Location:?c=dashboard&m=index");
            exit();
        }
    }

    public function index()
    {
        $title = 'User Account';

        $userModel = $this->loadModel("user");
        $result = $userModel->getAll();

        $this->loadView(
            "user/index",
            [
                'title' => $title,
                'users' => $result,
                'username' => $_SESSION['user']['name'],
                'role' => $_SESSION['user']['role'],
            ],
            'main'
        );
    }

    public function createUser()
    {
        $this->loadView(
            "user/user_create",
            [
                'title' => 'Create User',
                'username' => $_SESSION['user']['name'],
                'role' => $_SESSION['user']['role'],
            ],
            'main'
        );
    }

    public function insertStudent () {
        $title = 'Create User';

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';

        $userModel = $this->loadModel("user");
        $result = $userModel->createUser($name, $email, $password, $role);

        if ($result["isSuccess"]) {
            header("Location:?c=user&m=index");
        } else {
            $this->loadView(
                "user/user_create",
                [
                    'title' => $title,
                    'error' => $result['info'],
                    'username' => $_SESSION['user']['name'],
                    'role' => $_SESSION['user']['role'],
                ],
                'main'
            );
        }
    }

    public function editUser()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location:?c=user&m=index");
            exit;
        }

        $userModel = $this->loadModel("user");
        $result = $userModel->getById($id);

        if ($_SESSION['user']['role'] !== 'superadmin') {
            if ($result->role === 'superadmin') {
                $userModel = $this->loadModel("user");
                $result1 = $userModel->getAll();
                $this->loadView(
                    "user/index",
                    [
                        'title' => 'User Account',
                        'users' => $result1,
                        'error' => 'Tidak dapat akses mengedit user dengan role superadmin',
                        'username' => $_SESSION['user']['name'],
                        'role' => $_SESSION['user']['role'],
                    ],
                    'main'
                );
            }
        }

        if (!$result) {
            $userModel = $this->loadModel("user");
            $result2 = $userModel->getAll();
            $this->loadView(
                "user/index",
                [
                    'title' => 'User Account',
                    'users' => $result2,
                    'error' => "Tidak ada user dengan ID " . $id,
                    'username' => $_SESSION['user']['name'],
                    'role' => $_SESSION['user']['role'],
                ],
                'main'
            );
        }

        $this->loadView(
            "user/user_edit",
            [
                'title' => 'Edit User',
                'users' => $result,
                'username' => $_SESSION['user']['name'],
                'role' => $_SESSION['user']['role'],
            ],
            'main'
        );
    }

    public function updateUser()
    {
        $title = 'Edit user';

        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? '';
        // die(var_dump($id, $name, $email));

        if (!$id) {
            header("Location:?c=user&m=index");
            exit;
        }

        $userModel = $this->loadModel("user");
        $result = $userModel->updateUser($id, $name, $email, $role);

        if ($result["isSuccess"]) {
            $updatedUser = $userModel->getById($id);
            if($_SESSION['user']['id'] == $id) {
                $_SESSION['user']['name'] = $updatedUser->name;
                $_SESSION['user']['role'] = $updatedUser->role; 
                header("Location:?c=user&m=index");
            }
        } else {
            $userModel = $this->loadModel("user");
            $users = $userModel->getById($id);

            $this->loadView(
                "dashboard/profile_edit",
                [
                    'title' => $title,
                    'error' => $result['info'],
                    'users' => $users,
                    'username' => $_SESSION['user']['name'],
                    'role' => $_SESSION['user']['role'],
                ],
                'main'
            );
        }
    }

    public function deleteUser()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location:?c=user&m=index");
            exit;
        }

        $userModel = $this->loadModel("user");
        $result = $userModel->deleteUser($id);

        if ($result["isSuccess"]) {
            header("Location:?c=user&m=index");
        } else {
            $this->loadView(
                "user/index",
                [
                    'title' => 'User Account',
                    'error' => $result['info'],
                    'username' => $_SESSION['user']['name'],
                    'role' => $_SESSION['user']['role'],
                ],
                'main'
            );
        }
    }
}
