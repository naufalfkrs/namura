<?php
class UserController extends Controller
{
    protected $userModel;
    public function __construct()
    {
        $this->init();
        $this->check();
        $this->paginate('user');
        $this->userModel = $this->loadModel("user");

    }

    public function index()
    {
        $title = 'User Account';

        $result = $this->userModel->getAll($this->limit, $this->offset);

        $this->loadView(
            "user/index",
            [
                'title' => $title,
                'users' => $result,
            ],
            'main',
            'user'
        );
    }

    public function createUser()
    {
        $this->loadView(
            "user/user_create",
            [
                'title' => 'Create User',
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

        $result = $this->userModel->createUser($name, $email, $password, $role);

        if ($result["isSuccess"]) {
            header("Location:?c=user&m=index");
        } else {
            $this->loadView(
                "user/user_create",
                [
                    'title' => $title,
                    'error' => $result['info'],
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

        $result = $this->userModel->getById($id);

        if ($this->role !== 'superadmin') {
            if ($result->role === 'superadmin') {
                $result1 = $this->userModel->getAll();
                $this->loadView(
                    "user/index",
                    [
                        'title' => 'User Account',
                        'users' => $result1,
                        'error' => 'Tidak dapat mengedit user dengan role superadmin',
                    ],
                    'main',
                    'user'
                );
            }
        }

        if (!$result) {
            $result2 = $this->userModel->getAll();
            $this->loadView(
                "user/index",
                [
                    'title' => 'User Account',
                    'users' => $result2,
                    'error' => "Tidak ada user dengan ID " . $id,
                ],
                'main',
                'user'
            );
        }

        $this->loadView(
            "user/user_edit",
            [
                'title' => 'Edit User',
                'users' => $result,
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

        if (!$id) {
            header("Location:?c=user&m=index");
            exit;
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $user = $this->userModel->getById($id);
            $hashedPassword = $user->password;
        }
        $result = $this->userModel->updateUser($id, $name, $email, $hashedPassword, $role);

        if ($result["isSuccess"]) {
            $updatedUser = $this->userModel->getById($id);
            if($this->id == $id) {
                $this->username = $updatedUser->name;
                $this->role = $updatedUser->role; 
            }
            header("Location:?c=user&m=index");
        } else {
            $users = $this->userModel->getById($id);

            $this->loadView(
                "user/user_edit",
                [
                    'title' => $title,
                    'error' => $result['info'],
                    'users' => $users,
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

        $result = $this->userModel->deleteUser($id);

        if ($result["isSuccess"]) {
            header("Location:?c=user&m=index");
        } else {
            $this->loadView(
                "user/index",
                [
                    'title' => 'User Account',
                    'error' => $result['info'],
                ],
                'main',
                'user'
            );
        }
    }
}
