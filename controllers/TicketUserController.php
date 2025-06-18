<?php
include_once 'models/Ticket.php';

class TicketUserController extends Controller
{
    public function __construct()
    {
        $this->init();
    }

    public function index()
    {
        $ticketModel = $this->loadModel("ticket");
        $tickets = $ticketModel->getAll();

        if (!empty($tickets)) {
            $event_id = $tickets[0]['event_id'];
            header("Location:?c=ticketUser&m=form&id=" . $event_id);
            exit();
        } else {
            echo "Tidak ada tiket tersedia saat ini.";
        }
    }


    public function form()
    {
    
        $event_id = $_GET['id'] ?? null;
        if (!$event_id) {
            echo "ID event tidak ditemukan.";
            return;
        }

        $ticketModel = $this->loadModel("ticket");
        $tickets = $ticketModel->getByEventId($event_id);

        $this->loadView("ticket/form", [
            'title' => 'Form Pemesanan Tiket',
            'tickets' => $tickets,
            'event_id' => $event_id,
            'user_id' => $this->id
        ], "main");
    }

    public function submitOrder()
    {

        $user_id   = $_SESSION['user']['id'] ?? null;
        $ticket_id = $_POST['ticket_id'] ?? null;
        $jumlah    = $_POST['jumlah'] ?? null;
        $event_id  = $_POST['event_id'] ?? null;

        if (!$user_id || !$ticket_id || !$jumlah || !$event_id) {
            header("Location:?c=ticketUser&m=form&id=$event_id&status=error");
            exit();
        }

        $ticketModel = $this->loadModel("ticket");
        $ticket = $ticketModel->getById($ticket_id);

        if (!$ticket || $jumlah > $ticket->quota) {
            header("Location:?c=ticketUser&m=form&id=$event_id&status=overquote");
            exit();
        }

        $participantModel = $this->loadModel("participants");
        for ($i = 0; $i < $jumlah; $i++) {
            $participantModel->add($user_id, $event_id, $ticket_id, 'registered');
        }

        $ticketModel->reduceQuota($ticket_id, $jumlah);

        header("Location:?c=ticketUser&m=form&id=$event_id&status=ordered");
        exit();
    }

    public function getLastOrder()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $user_id = $_SESSION['user']['id'];

        $model = $this->loadModel('participants');
        $data = $model->getLastParticipantWithTicket($user_id);

        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tidak ada pemesanan ditemukan.']);
        }
    }
}
