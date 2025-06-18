<?php
class Sponsor extends Model
{
    public function getSponsorsByEventId($eventId)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM sponsors WHERE event_id = ? ORDER BY name ASC");
        $stmt->bind_param("i", $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSponsorById($sponsorId)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM sponsors WHERE sponsor_id = ?");
        $stmt->bind_param("i", $sponsorId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        } else {
            return null;
        }
    }

    public function addSponsor($data, $logoUrl)
    {
        $stmt = $this->dbconn->prepare("INSERT INTO sponsors (name, logo_url, contribution, event_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param(
            "sssi",
            $data['name'],
            $logoUrl,
            $data['contribution'],
            $data['event_id']
        );
        return $stmt->execute();
    }

    public function updateSponsor($data, $logoUrl = null)
    {
        if ($logoUrl) {
            $stmt = $this->dbconn->prepare("UPDATE sponsors SET name = ?, logo_url = ?, contribution = ? WHERE sponsor_id = ?");
            $stmt->bind_param(
                "sssi",
                $data['name'],
                $logoUrl,
                $data['contribution'],
                $data['sponsor_id']
            );
        } else {
            $stmt = $this->dbconn->prepare("UPDATE sponsors SET name = ?, contribution = ? WHERE sponsor_id = ?");
            $stmt->bind_param(
                "ssi",
                $data['name'],
                $data['contribution'],
                $data['sponsor_id']
            );
        }
        return $stmt->execute();
    }

    public function deleteSponsor($sponsorId)
    {
        $sponsor = $this->getSponsorById($sponsorId);
        if ($sponsor && !empty($sponsor->logo_url)) {
            if (file_exists($sponsor->logo_url)) {
                unlink($sponsor->logo_url);
            }
        }
        $stmt = $this->dbconn->prepare("DELETE FROM sponsors WHERE sponsor_id = ?");
        $stmt->bind_param("i", $sponsorId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}