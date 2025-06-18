<?php
class CommitteeController extends Controller 
{
    public function __construct() 
    {
        $this->init();
        $this->check();
    }

    public function index() // tampilkan dulu eventnya
    {
        $title = 'Manajemen Panitia';
        $committeeModel = $this->loadModel('Committee');
        $events = $committeeModel->getEvent();

        $this->loadView(
            "committee/index",
            [
                'title' => $title,
                'events' => $events
            ],
            'main'
        );
    }

    public function eventCommittee() // tampilkan panitia berdasarkan id event
    {
        $committeeModel = $this->loadModel('committee');
        $event_id = $_GET['id'] ?? null;
        
        $event = $committeeModel->getEventById($event_id);
        $title = "Manajemen Panitia $event->title"; 
        $committees = $committeeModel->getCommitteeEvent($event_id);

        $this->loadView(
            "committee/eventCom",
            [
                'title' => $title,
                'committees' => $committees,
                'event' => $event
            ],
            'main'
        );
    }

    public function createCommittee() // ke form tambah panitia
    {   
        $committeeModel = $this->loadModel('committee');
        $event_id = $_GET['id'] ?? null;

        $event = $committeeModel->getEventById($event_id);
        $title = "Tambah Panitia $event->title"; 

        $this->loadView(
            'committee/createCom',
            [
                'title' => $title, 
                'event_id' => $event_id
            ],
            'main'
        );
    }

    public function insertCommittee() // proses tambah panitia
    {
        $name = $_POST['name'] ?? '';
        $role = $_POST['role'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $event_id = $_GET['id'] ?? null;

        $committeeModel = $this->loadModel('committee');
        $event = $committeeModel->getEventById($event_id);
        $title = "Tambah Panitia $event->title"; 

        $committee = $committeeModel->createCommittee($event_id, $name, $role, $contact);  
        $event = $committeeModel->getEventById($event_id);

        if ($committee) {
            $committees = $committeeModel->getCommitteeEvent($event_id);
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => $title,
                    'committees' => $committees,
                    'event' => $event,
                    'success' => 'Panitia telah berhasil ditambahkan!'
                ],
                'main'
            );
        } else {
            $this->loadView(
                'committee/createCom',
                [
                    'title' => $title, 
                    'event_id' => $event_id, 
                    'error' => 'Duplikat panitia. Silakan coba lagi dengan data yang benar.'
                ],
                'main'
            );
        }
    }

    public function editCommittee()
    {
        $committee_id = $_GET['committee_id'] ?? null; 
        $event_id = $_GET['event_id'] ?? null;
        $committeeModel = $this->loadModel('committee');

        $committees = $committeeModel->getCommitteeEvent($event_id);
        $event = $committeeModel->getEventById($event_id);
        
        if (!$committee_id || !$event_id) {
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => "Manajemen Panitia $event->title",
                    'committees' => $committees,
                    'event' => $event,
                    'error' => 'Panitia tidak ditemukan.'
                ],
                'main'
            );
            return;
        }

        $committee = $committeeModel->getByComId($committee_id);
        if (!$committee) {
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => "Manajemen Panitia $event->title",
                    'committees' => $committees,
                    'event' => $event,
                    'error' => 'Panitia tidak ditemukan.'
                ],
                'mainCom'
            );
            return;
        }

        $this->loadView(
            'committee/editCom',
            [
                'title' => "Edit Panitia $event->title",
                'event_id' => $event_id,
                'committee' => $committee
            ],
            'main'
        );
    }

    public function updateCommittee()
    {
        $title = 'Perbarui Panitia';
        $committee_id = $_POST['committee_id'] ?? '';
        $event_id = $_GET['event_id'] ?? null;
        $name = $_POST['name'] ?? '';
        $role = $_POST['role'] ?? '';
        $contact = $_POST['contact'] ?? '';

        $committeeModel = $this->loadModel('committee');
        $result = $committeeModel->updateCommittee($event_id, $committee_id, $name, $role, $contact);

        $event = $committeeModel->getEventById($event_id);
        $committees = $committeeModel->getCommitteeEvent($event_id);

        if ($result) {
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => "Manajemen Panitia $event->title",
                    'committees' => $committees,
                    'event' => $event,
                    'success' => 'Panitia berhasil diperbarui!'
                ],
                'main'
            );
        } else {
            $committee = $committeeModel->getByComId($committee_id);
            $this->loadView(
                'committee/editCom',
                [
                    'title' => "Edit Panitia $event->title", 
                    'committee' => $committee, 
                    'event_id' => $event_id,
                    'error' => 'Duplikat panitia. Silakan coba lagi dengan data yang benar.'
                ],
                'main'
            );
        }
    }

    public function deleteCommittee()
    {
        $committeeModel = $this->loadModel('committee');
        $committee_id = $_GET['committee_id'] ?? null;
        $event_id = $_GET['event_id'] ?? null;

        $committees = $committeeModel->getCommitteeEvent($event_id);
        $event = $committeeModel->getEventById($event_id);

        if (!$committee_id || !$event_id) {
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => "Manajemen Panitia $event->title",
                    'committees' => $committees,
                    'event' => $event,
                    'error' => 'Panitia tidak ditemukan.'
                ],
                'main'
            );
            return;
        }

        $committee = $committeeModel->getByComId($committee_id);
        if (!$committee) {
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => "Manajemen Panitia $event->title",
                    'committees' => $committees,
                    'event' => $event,
                    'error' => 'Panitia tidak ditemukan.'
                ],
                'main'
            );
            return;
        }

        $result = $committeeModel->deleteCommittee($committee_id); 
        $committees = $committeeModel->getCommitteeEvent($event_id); 

        if ($result) {
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => "Manajemen Panitia $event->title",
                    'committees' => $committees,
                    'event' => $event,
                    'success' => 'Panitia berhasil dihapus!'
                ],
                'main'
            );
        } else {
            $this->loadView(
                'committee/eventCom',
                [
                    'title' => "Manajemen Panitia $event->title",
                    'committees' => $committees,
                    'event' => $event,
                    'error' => 'Gagal menghapus panitia. Silakan coba lagi.'
                ],
                'main'
            );
        }
    }
}