<?php

class Event extends Model
{
    public function getAllEvents()
    {
        $sql = "SELECT * FROM events ORDER BY start_date DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatestEvents($limit = 3)
    {
        $sql = "SELECT * FROM events ORDER BY start_date DESC LIMIT ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventById($id)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addEvent($data)
    {
        if (empty($data['title']) || empty($data['start_date']) || empty($data['end_date'])) {
            throw new Exception("Field judul, tanggal mulai, dan tanggal selesai wajib diisi.");
        }

        $stmt = $this->dbconn->prepare("INSERT INTO events (title, description, location, start_date, end_date, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $data['title'], $data['description'], $data['location'], $data['start_date'], $data['end_date'], $_SESSION['user_id']);
        $stmt->execute();
    }

    public function isEventUsedInTicketing($eventId)
    {
        $stmt = $this->dbconn->prepare("SELECT COUNT(*) as count FROM tickets WHERE event_id = ?");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0; // Mengembalikan true jika ada tiket terkait
    }

    public function updateEvent($data)
    {
        $stmt = $this->dbconn->prepare("UPDATE events SET title=?, description=?, location=?, start_date=?, end_date=? WHERE event_id=?");
        $stmt->bind_param("sssssi", $data['title'], $data['description'], $data['location'], $data['start_date'], $data['end_date'], $data['event_id']);
        $stmt->execute();
    }

    public function deleteEvent($id)
    {
        $stmt = $this->dbconn->prepare("DELETE FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    
    public function checkDuplicateEvent($title, $event_id = null)
    {
        $query = "SELECT * FROM events WHERE title = ?";
        if ($event_id !== null) {
            $query .= " AND event_id != ?";
        }

        $stmt = $this->dbconn->prepare($query);
        if ($event_id !== null) {
            $stmt->bind_param("si", $title, $event_id);
        } else {
            $stmt->bind_param("s", $title);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getEventsByDateRange($start_date, $end_date)
    {
        $sql = "SELECT * FROM events WHERE start_date >= ? AND end_date <= ? ORDER BY start_date ASC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countEvents()
    {
        $sql = "SELECT COUNT(*) as total FROM events";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
}