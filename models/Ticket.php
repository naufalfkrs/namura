<?php
include_once "models/Model.php";
class Ticket extends Model {
    
    private $lastErrorCode;
    public function __construct()
    {
        parent::__construct(); // Wajib agar $this->db aktif
    }

    // Ambil semua tiket dengan informasi nama event DAN jumlah tiket terjual
    public function getAll() 
    {
        $stmt = $this->dbconn->prepare("
            SELECT 
                t.*, 
                e.title as event_title,
                COALESCE(p.sold_count, 0) as tickets_sold
            FROM tickets t 
            LEFT JOIN events e ON t.event_id = e.event_id 
            LEFT JOIN (
                SELECT 
                    t2.ticket_id,
                    COUNT(DISTINCT p2.participant_id) as sold_count
                FROM tickets t2
                LEFT JOIN participants p2 ON t2.event_id = p2.event_id 
                    AND p2.status IN ('registered', 'attended')
                GROUP BY t2.ticket_id
            ) p ON t.ticket_id = p.ticket_id
            ORDER BY t.created_at DESC
        ");
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByEventId($eventId)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM tickets WHERE event_id = ?");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $tickets = [];
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
        return $tickets;
    }



    // Ambil data tiket berdasarkan ID
    public function getById($id)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM tickets WHERE ticket_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        } else {
            return null;
        }
    }

    // Ambil daftar event untuk dropdown, dll.
    public function getEvents()
    {
        $stmt = $this->dbconn->prepare("SELECT event_id, title FROM events");
        $stmt->execute();
        $result = $stmt->get_result();
        $events = [];
        while ($row = $result->fetch_object()) {
            $events[] = $row;
        }
        return $events;
    }


    // Tambahkan tiket baru
    public function createTicket($event_id, $type, $price, $quota)
    {
        $stmt = $this->dbconn->prepare("
            INSERT INTO tickets (event_id, type, price, quota, created_at) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("isdi", $event_id, $type, $price, $quota);
        try {
            $stmt->execute();
            return ["isSuccess" => true];
        } catch (mysqli_sql_exception $e) {
            return ["isSuccess" => false, "info" => "Error: " . $e->getMessage()];
        }
    }

    // Update data tiket
    public function updateTicket($ticket_id, $event_id, $type, $price, $quota)
    {
        try {
            $stmt = $this->dbconn->prepare("
                UPDATE tickets 
                SET event_id = ?, type = ?, price = ?, quota = ?, created_at = NOW() 
                WHERE ticket_id = ?
            ");
            
            $stmt->bind_param("isiii", $event_id, $type, $price, $quota, $ticket_id);
            $result = $stmt->execute();
            
            if ($result) {
                return ['isSuccess' => true, 'info' => 'Tiket berhasil diupdate'];
            } else {
                return ['isSuccess' => false, 'info' => 'Gagal mengupdate tiket'];
            }
        } catch (Exception $e) {
            return ['isSuccess' => false, 'info' => $e->getMessage()];
        }
    }
    
    // Hapus tiket
    public function deleteTicket($ticket_id)
    {
        $stmt = $this->dbconn->prepare("DELETE FROM tickets WHERE ticket_id = ?");
        $stmt->bind_param("i", $ticket_id);
        try {
            $stmt->execute();
            return ["isSuccess" => true];
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) {
                return ["isSuccess" => false, "info" => "Tiket tidak bisa dihapus karena masih terkait data lain"];
            } else {
                return ["isSuccess" => false, "info" => "Error: " . $e->getMessage()];
            }
        }
    }

    public function reduceQuota($ticket_id, $jumlah)
    {
        $stmt = $this->dbconn->prepare("UPDATE tickets SET quota = quota - ? WHERE ticket_id = ?");
        $stmt->bind_param("ii", $jumlah, $ticket_id);
        return $stmt->execute();
    }

}