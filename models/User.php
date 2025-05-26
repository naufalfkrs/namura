<?php
class User extends Model
{

    public function login($email, $pass)
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function register($user, $email, $pass)
    {
        $sql = "INSERT INTO users (name, email, password) VALUES ('$user', '$email', '$pass')";
        try {
            $this->dbconn->query($sql);
            $result = array("isSuccess" => true);
        } catch (mysqli_sql_exception $e) {
            $result = array("isSuccess" => false, "info" => "Duplikasi pada email");
        }
        return $result;
    }
}
