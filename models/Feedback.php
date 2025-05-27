<?php
class Feedback extends Model
{
    private $lastErrorCode;
    public function getAll()
    {
        $stmt = $this->dbconn->prepare("SELECT f.*, u.name, e.title FROM feedback f JOIN users u ON f.user_id = u.user_id JOIN events e ON f.event_id = e.event_id");
        // $stmt = $this->dbconn->prepare("SELECT * FROM feedback");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function getEvent()
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
        $stmt = $this->dbconn->prepare("SELECT * FROM feedback WHERE feedback_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        } else {
            return null;
        }
    }

    public function createFeedback($user_id, $event_id, $rating, $comment)
    {
        $stmt = $this->dbconn->prepare("INSERT INTO feedback (user_id, event_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $user_id, $event_id, $rating, $comment);
        try {
            $stmt->execute();
            $result = array("isSuccess" => true);
        } catch (mysqli_sql_exception $e) {
            $code = $e->getCode();
            if ($code == 1062) {
                $result = array("isSuccess" => false, "info" => "Duplikasi pada ..");
            } elseif ($code == 1452) {
                $result = array("isSuccess" => false, "info" => "Event tidak ditemukan");
            } elseif ($code == 1064) {
                $result = array("isSuccess" => false, "info" => "Kesalahan sintaks SQL");
            } elseif ($code == 4025) {
                $result = array("isSuccess" => false, "info" => "Rating harus antara 1 sampai 5");
            } else {
                $result = array("isSuccess" => false, "info" => "Error lainnya: " . $e->getMessage());
            }
        }
        return $result;
    }

    public function updateFeedback($id, $user_id, $event_id, $rating, $comment)
    {
        $stmt = $this->dbconn->prepare("UPDATE feedback SET user_id = ?, event_id = ?, rating = ?, comment = ?  WHERE feedback_id = ?");
        $stmt->bind_param("iiisi", $user_id, $event_id, $rating, $comment, $id);
        try {
            $stmt->execute();
            $result = array("isSuccess" => true);
        } catch (mysqli_sql_exception $e) {
            $code = $e->getCode();
            if ($code == 1062) {
                $result = array("isSuccess" => false, "info" => "Duplikasi pada ..");
            } elseif ($code == 1452) {
                $result = array("isSuccess" => false, "info" => "Event tidak ditemukan");
            } elseif ($code == 1064) {
                $result = array("isSuccess" => false, "info" => "Kesalahan sintaks SQL");
            } elseif ($code == 4025) {
                $result = array("isSuccess" => false, "info" => "Rating harus antara 1 sampai 5");
            } else {
                $result = array("isSuccess" => false, "info" => "Error lainnya: " . $e->getMessage());
            }
        }
        return $result;
    }

    public function deleteFeedback($id)
    {
        $stmt = $this->dbconn->prepare("DELETE FROM feedback WHERE feedback_id = ?");
        $stmt->bind_param("i", $id);
        try {
            $stmt->execute();
            return array("isSuccess" => true);
        } catch (mysqli_sql_exception $e) {
            $code = $e->getCode();
            if ($code == 1451) {
                return array("isSuccess" => false, "info" => "Tidak dapat menghapus feedback ini karena ada data terkait");
            } else {
                return array("isSuccess" => false, "info" => "Error lainnya: " . $e->getMessage());
            }
        }
    }
}
