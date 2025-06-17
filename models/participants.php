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
}
