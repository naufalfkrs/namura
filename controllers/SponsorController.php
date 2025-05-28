<?php
include_once "models/Sponsor.php";

class SponsorController extends Controller {

    private $sponsorModel;

    public function __construct() {
        $this->sponsorModel = $this->loadModel("sponsor");
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user'])) {
            header("Location:?c=auth&m=login");
            exit();
        }

        $sponsorModel = $this->loadModel("sponsor");
        $eventModel = $this->loadModel("event");

        $sponsors = $sponsorModel->getAll();
        $events = $eventModel->getAll(); // untuk nanti digunakan jika ingin tambah/edit

        $this->loadView("sponsor/index", [
            "title" => "Manajemen Sponsor",
            "sponsors" => $sponsors,
            "events" => $events
        ]);
    }

    public function create() {
        $events = $this->sponsorModel->getAllEvents();
        $this->loadView("sponsor/create", ['events' => $events], "main");
    }

    public function store() {
        $data = [
            'name' => $_POST['name'],
            'logo_url' => $_POST['logo_url'],
            'contribution' => $_POST['contribution'],
            'event_id' => $_POST['event_id']
        ];
        $this->sponsorModel->createSponsor($data);
        header("Location:?c=sponsor&m=index");
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location:?c=sponsor&m=index");
            exit();
        }
        $sponsor = $this->sponsorModel->getSponsorById($id);
        $events = $this->sponsorModel->getAllEvents();
        $this->loadView("sponsor/edit", ['sponsor' => $sponsor, 'events' => $events], "main");
    }

    public function update() {
        $id = $_POST['id'];
        $data = [
            'name' => $_POST['name'],
            'logo_url' => $_POST['logo_url'],
            'contribution' => $_POST['contribution'],
            'event_id' => $_POST['event_id']
        ];
        $this->sponsorModel->updateSponsor($id, $data);
        header("Location:?c=sponsor&m=index");
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->sponsorModel->deleteSponsor($id);
        }
        header("Location:?c=sponsor&m=index");
    }
}
