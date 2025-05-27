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

        if ($_SESSION['user']['role'] !== 'admin') {
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

        $profileModel = $this->loadModel("user");
        $result = $profileModel->createUser($name, $email, $password, $role);

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

        $profileModel = $this->loadModel("user");
        $result = $profileModel->getById($id);

        if (!$result) {
            header("Location:?c=user&m=index");
            exit;
        }

        $this->loadView(
            "user/user_edit",
            [
                'title' => 'Edit User',
                'profiles' => $result,
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

        $profileModel = $this->loadModel("user");
        $result = $profileModel->updateUser($id, $name, $email, $role);

        if ($result["isSuccess"]) {
            header("Location:?c=user&m=index");
        } else {
            $profileModel = $this->loadModel("user");
            $profiles = $profileModel->getById($id);

            $this->loadView(
                "dashboard/profile_edit",
                [
                    'title' => $title,
                    'error' => $result['info'],
                    'profiles' => $profiles,
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

        $profileModel = $this->loadModel("user");
        $result = $profileModel->deleteUser($id);

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
