<?php
class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->init();
        $this->check();
    }

    public function index()
    {
        $title = "Participants List";
        $model = $this->loadModel("Participants");
        $results = $model->getAll();

        $this->loadView("participants/index", [
            'title' => $title,
            'results' => $results,
        ], 'main');
    }

    public function create()
    {
        $model = $this->loadModel("Participants");
        $users = $model->getUsers();
        $events = $model->getEvents();

        $this->loadView("participants/participants_create", [
            'title' => "Add Participant",
            'users' => $users,
            'events' => $events,
        ], 'main');
    }

    public function insert()
    {
        $user_id = $_POST['user_id'] ?? '';
        $event_id = $_POST['event_id'] ?? '';
        $status = $_POST['status'] ?? 'registered';

        $model = $this->loadModel("Participants");

        $existing = $model->getByUserEvent($user_id, $event_id);
        if ($existing) {
            $users = $model->getUsers();
            $events = $model->getEvents();

            $this->loadView("participants/participants_create", [
                'title' => "Add Participant",
                'error' => "Peserta dengan kombinasi User dan Event ini sudah terdaftar.",
                'users' => $users,
                'events' => $events,
            ], 'main');
            return;
        }

        $result = $model->createParticipant($user_id, $event_id, $status);
        if ($result['isSuccess']) {
            header("Location:?c=participant&m=index");
        } else {
            $users = $model->getUsers();
            $events = $model->getEvents();

            $this->loadView("participants/participants_create", [
                'title' => "Add Participant",
                'error' => $result['info'],
                'users' => $users,
                'events' => $events,
            ], 'main');
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location:?c=participant&m=index");
            exit;
        }

        $model = $this->loadModel("Participants");
        $participant = $model->getById($id);
        if (!$participant) {
            header("Location:?c=participant&m=index");
            exit;
        }

        $users = $model->getUsers();
        $events = $model->getEvents();

        $this->loadView("participants/participants_edit", [
            'title' => "Edit Participant",
            'results' => $participant,
            'users' => $users,
            'events' => $events,
        ], 'main');
    }

    public function update()
    {
        $id = $_POST['id'] ?? null;
        $user_id = $_POST['user_id'] ?? '';
        $event_id = $_POST['event_id'] ?? '';
        $status = $_POST['status'] ?? 'registered';

        if (!$id) {
            header("Location:?c=participant&m=index");
            exit;
        }

        $model = $this->loadModel("Participants");

        $existing = $model->getByUserEvent($user_id, $event_id);
        if ($existing && $existing->participant_id != $id) {
            $participant = $model->getById($id);
            $users = $model->getUsers();
            $events = $model->getEvents();

            $this->loadView("participants/participants_edit", [
                'title' => "Edit Participant",
                'error' => "Kombinasi User dan Event ini sudah digunakan oleh peserta lain.",
                'results' => $participant,
                'users' => $users,
                'events' => $events,
            ], 'main');
            return;
        }

        $result = $model->updateParticipant($id, $user_id, $event_id, $status);
        if ($result['isSuccess']) {
            header("Location:?c=participant&m=index");
        } else {
            $participant = $model->getById($id);
            $users = $model->getUsers();
            $events = $model->getEvents();

            $this->loadView("participants/participants_edit", [
                'title' => "Edit Participant",
                'error' => $result['info'],
                'results' => $participant,
                'users' => $users,
                'events' => $events,
            ], 'main');
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location:?c=participant&m=index");
            exit;
        }

        $model = $this->loadModel("Participants");
        $result = $model->deleteParticipant($id);

        if ($result['isSuccess']) {
            header("Location:?c=participant&m=index");
        } else {
            $results = $model->getAll();
            $this->loadView("participants/index", [
                'title' => "Participants List",
                'error' => $result['info'],
                'results' => $results,
            ], 'main');
        }
    }

    public function ajaxReload()
    {
        $model = $this->loadModel("Participants");
        $results = $model->getAll();

        $this->loadView("participants/participants_ajax", [
            'results' => $results
        ]);
    }
}
