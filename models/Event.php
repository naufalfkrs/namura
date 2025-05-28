<?php
class Event extends Model {
    public function getAllEvents() {
        $result = $this->dbconn->query("SELECT * FROM events");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEventById($id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getById($id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM events WHERE event_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    public function addEvent($data) {
        $stmt = $this->dbconn->prepare("INSERT INTO events (title, description, location, start_date, end_date, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $data['title'], $data['description'], $data['location'], $data['start_date'], $data['end_date'], $_SESSION['user_id']);
        $stmt->execute();
    }

    public function updateEvent($data) {
        $stmt = $this->dbconn->prepare("UPDATE events SET title=?, description=?, location=?, start_date=?, end_date=? WHERE event_id=?");
        $stmt->bind_param("sssssi", $data['title'], $data['description'], $data['location'], $data['start_date'], $data['end_date'], $data['event_id']);
        $stmt->execute();
    }

    public function deleteEvent($id) {
        $stmt = $this->dbconn->prepare("DELETE FROM events WHERE event_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

}