<?php
class EventController extends Controller {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }
    }

    public function index() {
        $eventModel = $this->loadModel("event");
        $events = $eventModel->getAllEvents();
        $this->loadView("event/index", ['title' => 'Manajemen Event', 'events' => $events, 'username' => $_SESSION['user']['name'], 'role' => $_SESSION['user']['role']], "main");
    }
                
    public function create() {
        $this->loadView("event/create", ['title' => 'Tambah Event', 'username' => $_SESSION['user']['name'], 'role' => $_SESSION['user']['role']], "main");
    }

    public function store() {
        $eventModel = $this->loadModel("event");
        $eventModel->addEvent($_POST);
        header("Location:?c=event&m=index");
    }

    public function edit() {
        $eventModel = $this->loadModel("event");
        $event = $eventModel->getEventById($_GET['id']);
        $this->loadView("event/edit", ['title' => 'Edit Event', 'event' => $event, 'username' => $_SESSION['user']['name'], 'role' => $_SESSION['user']['role']], "main");
    }

    public function update() {
        $eventModel = $this->loadModel("event");
        $eventModel->updateEvent($_POST);
        header("Location:?c=event&m=index");
    }

    public function delete() {
        $eventModel = $this->loadModel("event");
        $eventModel->deleteEvent($_GET['id']);
        header("Location:?c=event&m=index");
    }
    public function detail()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID event tidak ditemukan.";
            return;
        }

        $eventModel = $this->loadModel("event");
        $event = $eventModel->getEventById($id); 

        if (!$event) {
            echo "Event tidak ditemukan.";
            return;
        }

        $this->loadView("event/detail", [
            'title' => 'Detail Event',
            'event' => $event,
            'username' => $_SESSION['user']['name'], 
            'role' => $_SESSION['user']['role']
        ], "main");
    }


}