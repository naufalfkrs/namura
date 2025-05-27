<?php
class User extends Model
{
    private $lastErrorCode;
    public function login($email)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_object();
        } else {
            return null;
        }
    }

    public function register($user, $email, $pass)
    {
        $hashPass = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $this->dbconn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $email, $hashPass);
        try {
            $stmt->execute();
            $result = array("isSuccess" => true);
        } catch (mysqli_sql_exception $e) {
        $code = $e->getCode();
        if ($code == 1062) {
            $result = array("isSuccess" => false, "info" => "Duplikasi pada email");
        } elseif ($code == 1064) {
            $result = array("isSuccess" => false, "info" => "Kesalahan sintaks SQL");
        } else {
            $result = array("isSuccess" => false, "info" => "Error lainnya: " . $e->getMessage());
        }
        }
        return $result;
    }

    public function getById($id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_object();
        } else {
            return null;
        }
    }

    public function update($id, $name, $email) {
        $stmt = $this->dbconn->prepare("UPDATE users SET name = ?, email = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $name, $email, $id);
        try {
            $stmt->execute();
            $result = array("isSuccess" => true);
        } catch (mysqli_sql_exception $e) {
        $code = $e->getCode();
        if ($code == 1062) {
            $result = array("isSuccess" => false, "info" => "Duplikasi pada Email");
            $this->lastErrorCode = $code;
        } elseif ($code == 1064) {
            $result = array("isSuccess" => false, "info" => "Kesalahan sintaks SQL");
            $this->lastErrorCode = $code;
        } else {
            $result = array("isSuccess" => false, "info" => "Error lainnya: " . $e->getMessage());
            $this->lastErrorCode = $code;
        }
        }
        return $result;
    }
}
