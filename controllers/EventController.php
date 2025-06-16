<?php

class EventController extends Controller
{
    public function __construct()
    {
        $this->init();
    }

    public function list()
    {
        $eventModel = $this->loadModel("event");
        $events = $eventModel->getAllEvents();

        if (empty($events)) {
            error_log("No events found in the database.");
        }

        $this->loadView("event/list", [
            'title' => 'Daftar Event',
            'events' => $events
        ], "main");
    }

    public function dashboard()
    {
        $eventModel = $this->loadModel("event");
        $events = $eventModel->getLatestEvents(3);

        $this->loadView("dashboard/index", [
            'title' => 'Dashboard',
            'events' => $events
        ], "main");
    }

    public function index()
    {
        $this->check();
        $eventModel = $this->loadModel("event");
        $events = $eventModel->getAllEvents();

        $this->loadView("event/index", [
            'title' => 'Manajemen Event',
            'events' => $events
        ], "main");
    }

    public function create()
    {
        $this->check();
        $old = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);

        $this->loadView("event/create", [
            'title' => 'Tambah Event',
            'old' => $old
        ], "main");
    }

    public function store()
    {
        $this->check();
        $eventModel = $this->loadModel("event");

        try {
            if (empty($_POST['title']) || empty($_POST['start_date']) || empty($_POST['end_date'])) {
                throw new Exception("Field judul, tanggal mulai, dan tanggal selesai wajib diisi.");
            }

            //Cek duplikat berdasarkan title saja
            $isDuplicate = $eventModel->checkDuplicateEvent($_POST['title']);
            if ($isDuplicate) {
                $_SESSION['error_message_popup'] = '❌ Judul event sudah digunakan. Judul harus unik.';
                $_SESSION['old_input'] = $_POST;
                header("Location: ?c=event&m=create");
                return;
            }

            // Jika tidak duplikat
            $eventModel->addEvent($_POST);
            $_SESSION['success_message_popup'] = '✅ Event berhasil ditambahkan.';
            header("Location: ?c=event&m=index");
        } catch (Exception $e) {
            $_SESSION['error_message'] = "❌ Terjadi kesalahan: " . $e->getMessage();
            $_SESSION['old_input'] = $_POST;
            header("Location: ?c=event&m=create");
        }
    }

    public function edit()
    {
        $this->check();
        $eventModel = $this->loadModel("event");
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            echo "ID tidak valid.";
            return;
        }

        $event = $eventModel->getEventById($id);
        if (!$event) {
            echo "Event tidak ditemukan.";
            return;
        }

        $this->loadView("event/edit", [
            'title' => 'Edit Event',
            'event' => $event
        ], "main");
    }

    public function update()
    {
        $this->check();
        $eventModel = $this->loadModel("event");

        try {
            if (
                empty($_POST['title']) ||
                empty($_POST['start_date']) ||
                empty($_POST['end_date']) ||
                empty($_POST['event_id'])
            ) {
                throw new Exception("Field judul, tanggal mulai, tanggal selesai, dan ID event wajib diisi.");
            }

            // Cek duplikat judul tapi abaikan dirinya sendiri
            $isDuplicate = $eventModel->checkDuplicateEvent($_POST['title'], $_POST['event_id']);
            if ($isDuplicate) {
                echo json_encode([
                    'status' => 'error',
                    'message' => '❌ Judul event ini sudah digunakan.'
                ]);
                return;
            }

            // Jika tidak duplikat, update
            $eventModel->updateEvent($_POST);

            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function checkTicketing()
    {
        header('Content-Type: application/json');

        $eventModel = $this->loadModel("event");
        $eventId = $_GET['id'] ?? null;

        if (!$eventId || !is_numeric($eventId)) {
            echo json_encode([
                'isInTicketing' => false,
                'error' => 'ID tidak valid'
            ]);
            return;
        }

        try {
            $isUsed = $eventModel->isEventUsedInTicketing($eventId);
            echo json_encode(['isInTicketing' => $isUsed]);
        } catch (Exception $e) {
            echo json_encode([
                'isInTicketing' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function delete()
    {
        $this->check();
        $eventModel = $this->loadModel("event");
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            echo "ID tidak valid.";
            return;
        }

        try {
            $eventModel->deleteEvent($id); // Hapus event dari database
            $_SESSION['success_message_popup'] = "Event berhasil dihapus.";
        } catch (Exception $e) {
            $_SESSION['error_message_popup'] = "Gagal menghapus event: " . $e->getMessage();
        }

        header("Location:?c=event&m=index");
    }


    public function detailAjax()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo "ID tidak valid.";
            return;
        }

        $eventModel = $this->loadModel("event");
        $event = $eventModel->getEventById($id);

        if (!$event) {
            http_response_code(404);
            echo "Event tidak ditemukan.";
            return;
        }

        include 'views/event/detailAjax.php';
    }
}