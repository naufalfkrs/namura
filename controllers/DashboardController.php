<?php
class DashboardController extends Controller {
    protected $userModel;
    protected $eventModel;
    protected $events;

    public function __construct() {
        $this->init();
        $this->userModel = $this->loadModel("user");
        $this->eventModel = $this->loadModel("event");
        $this->events = $this->eventModel->getAllEvents();
    }
    
    public function index() { 
        $title = 'Dashboard';

        $this->loadView(
            "dashboard/index",
            [
                'title' => $title,
                'events' => $this->events,
            ],
            'main'
        );
    }

    public function indexAdmin() { 
        $this->check();
        $title = 'Dashboard Admin';

        $this->loadView(
            "dashboard/index",
            [
                'title' => $title,
                'events' => $this->events,
            ],
            'main'
        );
    }

    public function profile() { 
        $title = 'Profile';

        $result = $this->userModel->getById($this->id);
        $this->loadView(
            "dashboard/profile",
            [
                'title' => $title,
                'profiles' => $result,
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

        $result = $this->userModel->getById($id);

        if (!$result) {
            header("Location:?c=dashboard&m=profile");
            exit;
        }

        $this->loadView(
            "dashboard/profile_edit",
            [
                'title' => 'Edit Profile',
                'profiles' => $result,
            ],
            'main'
        );
    }

    public function updateProfile() {
        $title = 'Edit Profile';

        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $foto = $_FILES['foto'] ?? null;

        if (!$id) {
            header("Location:?c=dashboard&m=profile");
            exit;
        }

        $getdata = $this->userModel->getById($id);

        // Jika foto ada
        if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($foto['type'], $allowedMimeTypes)) {
                $error = "Only JPEG, PNG, and GIF images are allowed.";
                $this->loadView(
                    "dashboard/profile_edit",
                    [
                        'title' => $title,
                        'error' => $error,
                        'profiles' => $this->userModel->getById($id),
                    ],
                    'main'
                );
                return;
            }

            if (file_exists($getdata->foto)) {
                unlink($getdata->foto);
            }

            $uploadDir = 'src/photo/';
            $fileName = $id . "_t" . date('Ymd') . "_" . basename($foto['name']);
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($foto['tmp_name'], $uploadPath)) {
                // Jika berhasil update beserta foto
                $result = $this->userModel->update($id, $name, $email, $uploadPath);
            } else {
                $error = "There was an error uploading your photo.";
                $this->loadView(
                    "dashboard/profile_edit",
                    [
                        'title' => $title,
                        'error' => $error,
                        'profiles' => $this->userModel->getById($id),
                    ],
                    'main'
                );
                return;
            }
        } else {
            // Jika tidak update foto
            $uploadPath = $getdata->foto;
            $result = $this->userModel->update($id, $name, $email, $uploadPath);
        }
        
        if ($result["isSuccess"]) {
            $updatedUser = $this->userModel->getById($id);

            $_SESSION['user']['name'] = $updatedUser->name;
            $_SESSION['user']['foto'] = $updatedUser->foto;

            header("Location:?c=dashboard&m=profile");
        } else {
            $profiles = $this->userModel->getById($id);

            $this->loadView(
                "dashboard/profile_edit",
                [
                    'title' => $title,
                    'error' => $result['info'],
                    'profiles' => $profiles,
                ],
                'main'
            );
        }
    }
}