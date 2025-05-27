<?php
include_once "models/Model.php";

class Sponsor extends Model {
    
    public function getAll() {
        $query = "SELECT name, titlee AS event_name 
                  FROM sponsors s
                  LEFT JOIN events e ON s.event_id = e.event_id";
        $result = $this->dbconn->query($query);
        $sponsors = [];

        while ($row = $result->fetch_assoc()) {
            $sponsors[] = $row;
        }

        return $sponsors;
    }

    public function getSponsorById($id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM sponsors WHERE sponsor_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createSponsor($data) {
        $stmt = $this->dbconn->prepare("
            INSERT INTO sponsors (name, logo_url, contribution, event_id) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("sssi", $data['name'], $data['logo_url'], $data['contribution'], $data['event_id']);
        return $stmt->execute();
    }

    public function updateSponsor($id, $data) {
        $stmt = $this->dbconn->prepare("
            UPDATE sponsors 
            SET name = ?, logo_url = ?, contribution = ?, event_id = ?
            WHERE sponsor_id = ?
        ");
        $stmt->bind_param("sssii", $data['name'], $data['logo_url'], $data['contribution'], $data['event_id'], $id);
        return $stmt->execute();
    }

    public function deleteSponsor($id) {
        $stmt = $this->dbconn->prepare("DELETE FROM sponsors WHERE sponsor_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAllEvents() {
        $stmt = $this->dbconn->prepare("SELECT * FROM events");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}