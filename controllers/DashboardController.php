<?php
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

        $profileModel = $this->loadModel("user");
        $result = $profileModel->getById($_SESSION['user']['id']);

        $this->loadView(
            "dashboard/index",
            [
                'title' => $title,
                'username' => $result->name,
                'role' => $result->role,
            ],
            'main'
        );
    }

    public function indexAdmin() { 
        $title = 'Dashboard Admin';

        $profileModel = $this->loadModel("user");
        $result = $profileModel->getById($_SESSION['user']['id']);

        $this->loadView(
            "dashboard/index",
            [
                'title' => $title,
                'username' => $result->name,
                'role' => $result->role,
            ],
            'main'
        );
    }

    public function profile() { 
        $title = 'Profile';

        $profileModel = $this->loadModel("user");
        $result = $profileModel->getById($_SESSION['user']['id']);
        $this->loadView(
            "dashboard/profile",
            [
                'title' => $title,
                'username' => $result->name,
                'profiles' => $result
            ],
            'main'
        );
    }

    public function editProfile() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location:?c=dashboard&m=profile");
            exit;
        }

        $profileModel = $this->loadModel("user");
        $result = $profileModel->getById($id);

        if (!$result) {
            header("Location:?c=dashboard&m=profile");
            exit;
        }

        $this->loadView(
            "dashboard/profile_edit",
            [
                'title' => 'Edit Profile',
                'username' => $result->name,
                'profiles' => $result
            ],
            'main'
        );
    }

    public function updateProfile() {
      $title = 'Edit Profile';

      $id = $_POST['id'] ?? null;
      $name = $_POST['name'] ?? '';
      $email = $_POST['email'] ?? '';
      // die(var_dump($id, $name, $email));

      if (!$id) {
        header("Location:?c=dashboard&m=profile");
        exit;
      }

      $profileModel = $this->loadModel("user");
      $result = $profileModel->update($id, $name, $email);

      if ($result["isSuccess"]) {
        header("Location:?c=dashboard&m=profile");
      } else {
        $profileModel = $this->loadModel("user");
        $profiles = $profileModel->getById($id);

        $this->loadView(
          "dashboard/profile_edit",
          [
            'title' => $title,
            'error' => $result['info'],
            'username' => $profiles->name,
            'profiles' => $profiles,
          ],
          'main'
        );
      }
    }
}