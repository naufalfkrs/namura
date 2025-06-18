<?php
include_once 'models/Ticket.php';

class TicketController extends Controller
{
    public function __construct()
    {
        $this->init();
        $this->check();
    }

    public function index()
    {
        $ticketModel = new Ticket();
        $tickets = $ticketModel->getAll();

        $this->loadView("ticket/index", [
            'tickets' => $tickets,
            'title' => 'Manajemen Tiket',
        ], 'main');
    }

    public function create()
    {
        $ticketModel = new Ticket();
        $events = $ticketModel->getEvents();

        $this->loadView("ticket/create", [
            'events' => $events,
            'title' => 'Tambah Tiket',
        ], 'main');
    }

    public function store()
    {
        if (
            !isset($_POST['event_id']) ||
            !isset($_POST['type']) ||
            !isset($_POST['price']) ||
            !isset($_POST['quota'])
        ) {
            echo "Data tidak lengkap. Semua field harus diisi.";
            return;
        }

        $ticketModel = new Ticket();
        $result = $ticketModel->createTicket(
            $_POST['event_id'],
            $_POST['type'],
            $_POST['price'],
            $_POST['quota']
        );

        if ($result['isSuccess']) {
            header('Location:?c=ticket&m=index&status=created');
        } else {
            echo "Gagal menambahkan tiket: " . $result['info'];
        }
    }

    public function edit()
    {
        if (!isset($_GET['id'])) {
            echo "ID tiket tidak ditemukan";
            return;
        }

        $id = $_GET['id'];
        $ticketModel = new Ticket();
        $ticket = $ticketModel->getById($id);

        if ($ticket) {
            $ticket = (array) $ticket;
            $events = $ticketModel->getEvents();

            $this->loadView("ticket/edit", [
                'ticket' => $ticket,
                'events' => $events,
                'title' => 'Edit Tiket',
            ], 'main');
        } else {
            echo "Tiket tidak ditemukan";
        }
    }

    public function update()
    {
        if (
            !isset($_POST['ticket_id']) ||
            !isset($_POST['event_id']) ||
            !isset($_POST['type']) ||
            !isset($_POST['price']) ||
            !isset($_POST['quota'])
        ) {
            echo "Data tidak lengkap. Semua field harus diisi.";
            return;
        }

        $ticketModel = new Ticket();
        $oldTicket = $ticketModel->getById($_POST['ticket_id']);

        if (!$oldTicket) {
            echo "Tiket tidak ditemukan";
            return;
        }

        $oldTicket = (array) $oldTicket;

        if (
            $oldTicket['event_id'] == $_POST['event_id'] &&
            $oldTicket['type'] == $_POST['type'] &&
            $oldTicket['price'] == $_POST['price'] &&
            $oldTicket['quota'] == $_POST['quota']
        ) {
            header("Location:?c=ticket&m=edit&id=" . $_POST['ticket_id'] . "&status=no_changes");
            return;
        }

        $result = $ticketModel->updateTicket(
            $_POST['ticket_id'],
            $_POST['event_id'],
            $_POST['type'],
            $_POST['price'],
            $_POST['quota']
        );

        if ($result['isSuccess']) {
            header('Location:?c=ticket&m=index&status=updated');
        } else {
            echo "Gagal mengupdate tiket: " . $result['info'];
        }
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            echo "ID tiket tidak ditemukan";
            return;
        }

        $id = $_GET['id'];
        $ticketModel = new Ticket();
        $result = $ticketModel->deleteTicket($id);

        if ($result['isSuccess']) {
            header('Location:?c=ticket&m=index&status=deleted');
        } else {
            echo "Gagal menghapus tiket: " . $result['info'];
        }
    }

    public function detailAjax()
    {
        if (!isset($_GET['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
            return;
        }

        $id = $_GET['id'];
        $ticketModel = new Ticket();
        $ticket = $ticketModel->getById($id);

        if ($ticket) {
            echo json_encode(['success' => true, 'data' => $ticket]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tiket tidak ditemukan']);
        }
    }
}
