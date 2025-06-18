<?php
class Committee extends Model 
{
    protected $lastErrorCode;

    public function getEvent() // mengambil semua event
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM events");
        $stmt->execute();
        $result = $stmt->get_result();
        $events = [];
        while ($row = $result->fetch_object()) {
            $events[] = $row;
        }

        return $events;
    }
    
    public function getEventById($event_id) // mengambil event berdasarkan ID
    {
        if (empty($event_id)) {
            throw new InvalidArgumentException("Event ID is required.");
        }

        $stmt = $this->dbconn->prepare("SELECT * FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_object();

        if (!$event) {
            return null; // Jika tidak ditemukan, kembalikan null
        }

        return $event;
    }

    public function getCommitteeEvent($event_id) // mengambil panitia berdasarkan ID event
    {
        if (empty($event_id)) {
            throw new InvalidArgumentException("Event ID is required.");
        }

        $stmt = $this->dbconn->prepare("SELECT * FROM committees WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $committees = [];
        while ($row = $result->fetch_object()) {
            $committees[] = $row;
        }

        return $committees;
    }

    public function getByComId($committee_id) // mengambil panitia berdasarkan ID panitia
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM committees WHERE committee_id = ?");
        $stmt->bind_param("i", $committee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new NotFoundException("Committee with ID {$committee_id} not found.");
        }

        return $result->fetch_object();
    }

    public function createCommittee($event_id, $name, $role, $contact) // tambah panitia
    {
        $stmt = $this->dbconn->prepare("
            SELECT COUNT(*) as count 
            FROM committees 
            WHERE event_id = ? AND name = ? AND contact = ?
        ");
        $stmt->bind_param("iss", $event_id, $name, $contact);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                return false;
            }
        }

        $stmt = $this->dbconn->prepare("
            INSERT INTO committees (event_id, name, role, contact) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("isss", $event_id, $name, $role, $contact);
        $result = $stmt->execute();

        return $result;
    }

    public function updateCommittee($event_id, $committee_id, $name, $role, $contact) // update data panitia
    {
        $stmt = $this->dbconn->prepare("
            SELECT COUNT(*) as count 
            FROM committees 
            WHERE (event_id = ? AND name = ? AND contact = ?) 
            AND committee_id != ?
        ");
        $stmt->bind_param("issi", $event_id, $name, $contact, $committee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['count'] > 0) {
                return false;
            }
        }

        $stmt = $this->dbconn->prepare("
            UPDATE committees 
            SET name = ?, role = ?, contact = ? 
            WHERE committee_id = ?
        ");
        $stmt->bind_param("sssi", $name, $role, $contact, $committee_id);
        $result = $stmt->execute();

        if (!$result) {
            throw new InternalServerErrorException("Failed to update committee: " . $stmt->error);
        }

        return true;
    }

    public function deleteCommittee($committee_id) // hapus panitia
    {
        $stmt = $this->dbconn->prepare("DELETE FROM committees WHERE committee_id = ?");
        $stmt->bind_param("i", $committee_id);
        $result = $stmt->execute();

        return $result;
    }
}