<?php
require_once '../../config/database.php';
require_once '../model/User.php';

//header("Content-Type: application/json; charset=UTF-8");

class UserRepository {


    public function __construct() {}

    public function getUser($email, $password): bool {
        global $conn;
        $sql = "SELECT `name` FROM users WHERE email = ? AND `password` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows() > 0) {
           // $conn->close();
            return true;
        }
        
       // $conn->close();
        return false;
    }

    public function insertUser($user): bool {
        global $conn;
        $sql = "INSERT INTO users (name, email, `password`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $stmt->bind_param("sss", $name, $email, $password); 
        $stmt->execute();
        //$stmt->store_result();

        if($stmt->affected_rows > 0) {
           // $conn->close();
            return true;
        }
       // $conn->close();
        return false;
    }
    
    public function exists($email): bool {
        global $conn;
        $sql = "SELECT `name` FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) {        
           // $conn->close();
            return true;
        }

       // $conn->close();
        return false;
    }

    public function getUserPassword($email) {
        global $conn;
        $sql = "SELECT `password` FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($password);
        $stmt->fetch();
        //$conn->close();
        return $password;   
    }

    public function blockUser($email) {
        global $conn;
        $sql = "UPDATE users SET isBlocked = 1 WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows) {        
            return true;
        }
        return false;
    }

    public function unblockUser($email) {
        global $conn;
        $sql = "UPDATE users SET isBlocked = 0 WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows) {        
            return true;
        }
        return false;
    }

    public function isBlocked($email) {
        global $conn;
        $sql = "SELECT name FROM users WHERE email = ? AND isBlocked = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) return true;
        
        return false;
    }

    public function auditar($usuario, $evento, $fecha) {
        global $conn;
        $sql = "INSERT INTO bitacora_users (fecha, usuario, evento) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $fecha, $usuario, $evento);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows) return true;
        
        return false;
    }

    public function addLoginLog($user_id, $browser, $ip, $device, $description) {
        global $conn;
        $sql = "INSERT INTO bitacora_login (user_id, browser, ip, device, `description`)
                VALUES(?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issss',$user_id, $browser, $ip, $device, $description);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->affected_rows) return true;

        return false;
    }

    public function getUserId($email) {
        global $conn;
        $sql = "SELECT id FROM users WHERE email = ? AND isBlocked = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id);
        if($stmt->fetch()) return $id;
        
        return 0;
    }
}
?>