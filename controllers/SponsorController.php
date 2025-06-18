<?php
class SponsorController extends Controller
{
    public function __construct()
    {
        $this->init();
        $this->check();
    }

    public function index()
    {
        $eventModel = $this->loadModel("event");
        $events = $eventModel->getAllEvents();

        $this->loadView("sponsor/list_events", [
            'title' => 'Manajemen Sponsor - Pilih Event',
            'events' => $events,
        ], "main");
    }

    public function manage()
    {
        $eventId = $_GET['event_id'] ?? null;
        if (!$eventId) {
            header("Location: ?c=sponsor&m=index");
            exit();
        }

        $sponsorModel = $this->loadModel("sponsor");
        $eventModel = $this->loadModel("event");

        $sponsors = $sponsorModel->getSponsorsByEventId($eventId);
        $event = $eventModel->getEventById($eventId);

        $this->loadView("sponsor/index", [
            'title' => 'Kelola Sponsor: ' . htmlspecialchars($event['title']),
            'sponsors' => $sponsors,
            'event' => $event,
        ], "main");
    }

    public function create()
    {
        $eventId = $_GET['event_id'] ?? null;
        if (!$eventId) {
            header("Location: ?c=sponsor&m=index");
            exit();
        }
        $eventModel = $this->loadModel("event");
        $event = $eventModel->getEventById($eventId);
        $this->loadView("sponsor/create", ['title' => 'Tambah Sponsor Baru', 'event' => $event, 'username' => $_SESSION['user']['name'], 'role' => $_SESSION['user']['role']], "main");
    }

    public function store()
    {
        $eventId = $_POST['event_id'];
        $logoUrl = $this->handleLogoUpload($_FILES['logo']);
        if ($logoUrl !== false) {
            $sponsorModel = $this->loadModel("sponsor");
            $sponsorModel->addSponsor($_POST, $logoUrl);
        }
        header("Location:?c=sponsor&m=manage&event_id=" . $eventId);
    }

    public function edit()
    {
        $sponsorId = $_GET['id'] ?? null;
        if (!$sponsorId) {
            header("Location: ?c=sponsor&m=index");
            exit();
        }
        $sponsorModel = $this->loadModel("sponsor");
        $sponsor = $sponsorModel->getSponsorById($sponsorId);
        $this->loadView("sponsor/edit", ['title' => 'Edit Sponsor', 'sponsor' => $sponsor, 'username' => $_SESSION['user']['name'], 'role' => $_SESSION['user']['role']], "main");
    }

    public function update()
    {
        $sponsorId = $_POST['sponsor_id'];
        $eventId = $_POST['event_id'];
        $sponsorModel = $this->loadModel("sponsor");
        $logoUrl = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $oldSponsor = $sponsorModel->getSponsorById($sponsorId);
            if ($oldSponsor && !empty($oldSponsor->logo_url) && file_exists($oldSponsor->logo_url)) {
                unlink($oldSponsor->logo_url);
            }
            $logoUrl = $this->handleLogoUpload($_FILES['logo']);
        }
        $sponsorModel->updateSponsor($_POST, $logoUrl);
        header("Location:?c=sponsor&m=manage&event_id=" . $eventId);
    }

    public function delete()
    {
        $sponsorId = $_GET['id'] ?? null;
        $eventId = $_GET['event_id'] ?? null;
        if ($sponsorId) {
            $sponsorModel = $this->loadModel("sponsor");
            $sponsorModel->deleteSponsor($sponsorId);
        }
        if ($eventId) {
            header("Location:?c=sponsor&m=manage&event_id=" . $eventId);
        } else {
            header("Location:?c=sponsor&m=index");
        }
    }

    private function handleLogoUpload($fileData) {
        if (!isset($fileData) || $fileData['error'] !== UPLOAD_ERR_OK) return "";
        $uploadDir = 'src/uploads/logos/';
        $fileName = time() . '_' . basename($fileData['name']);
        $targetPath = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        if (getimagesize($fileData['tmp_name']) === false) return false;
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) return false;
        if (move_uploaded_file($fileData['tmp_name'], $targetPath)) return $targetPath;
        return false;
    }

    public function ajaxDelete() {
        header('Content-Type: application/json');
        $sponsorId = $_GET['id'] ?? null;
        $response = ['success' => false, 'message' => 'ID Sponsor tidak valid.'];

        if ($sponsorId) {
            $sponsorModel = $this->loadModel("sponsor");
            if ($sponsorModel->deleteSponsor($sponsorId)) {
                $response = ['success' => true, 'message' => 'Sponsor berhasil dihapus.'];
            } else {
                // Jika gagal, ambil pesan error spesifik dari database
                $db_error = $sponsorModel->getDbError();
                $response = ['success' => false, 'message' => 'Gagal menghapus sponsor dari database.', 'db_error' => $db_error];
            }
        }

        echo json_encode($response);
        exit();
    }
}