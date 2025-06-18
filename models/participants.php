<?php
class Participants extends Model
{
    public function getAll()
    {
        $stmt = $this->dbconn->prepare("SELECT p.*, u.name, e.title FROM participants p 
            JOIN users u ON p.user_id = u.user_id 
            JOIN events e ON p.event_id = e.event_id");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUsers()
    {
        $stmt = $this->dbconn->prepare("SELECT user_id, name FROM users");
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = $row;
        }
        return $users;
    }

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

    public function getById($id)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM participants WHERE participant_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        }
        return null;
    }

    public function getByUserEvent($user_id, $event_id)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM participants WHERE user_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $user_id, $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        }
        return null;
    }

    public function createParticipant($user_id, $event_id, $status)
    {
        $stmt = $this->dbconn->prepare("INSERT INTO participants (user_id, event_id, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $event_id, $status);
        try {
            $stmt->execute();
            return ["isSuccess" => true];
        } catch (mysqli_sql_exception $e) {
            return ["isSuccess" => false, "info" => "Error: " . $e->getMessage()];
        }
    }

    public function updateParticipant($id, $user_id, $event_id, $status)
    {
        $stmt = $this->dbconn->prepare("UPDATE participants SET user_id = ?, event_id = ?, status = ? WHERE participant_id = ?");
        $stmt->bind_param("iisi", $user_id, $event_id, $status, $id);
        try {
            $stmt->execute();
            return ["isSuccess" => true];
        } catch (mysqli_sql_exception $e) {
            return ["isSuccess" => false, "info" => "Error: " . $e->getMessage()];
        }
    }

    public function deleteParticipant($id)
    {
        $stmt = $this->dbconn->prepare("DELETE FROM participants WHERE participant_id = ?");
        $stmt->bind_param("i", $id);
        try {
            $stmt->execute();
            return ["isSuccess" => true];
        } catch (mysqli_sql_exception $e) {
            return ["isSuccess" => false, "info" => "Error: " . $e->getMessage()];
        }
    }

    public function add($user_id, $event_id, $ticket_id, $status = 'registered') 
    {
        $stmt = $this->dbconn->prepare("
            INSERT INTO participants (user_id, event_id, ticket_id, status) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("iiis", $user_id, $event_id, $ticket_id, $status);
        return $stmt->execute();
    }

    //tambahan lagi
    public function getLastParticipantWithTicket($user_id)
    {
        $stmt = $this->dbconn->prepare("
            SELECT 
                p.participant_id,
                u.name as user_name,
                e.title as event_title,
                t.ticket_id,
                t.type as ticket_type,
                t.price,
                p.created_at
            FROM participants p
            JOIN users u ON p.user_id = u.user_id
            JOIN events e ON p.event_id = e.event_id
            JOIN tickets t ON p.ticket_id = t.ticket_id
            WHERE p.user_id = ?
            ORDER BY p.created_at DESC
            LIMIT 1
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
