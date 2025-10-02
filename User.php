 <!-- ye ek users login register aur user details ke liye hai -->
<?php
require_once 'database.php';

class User {
    private $conn;
    
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function login($email, $password) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = md5($password);
        
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function register($name, $email, $phone, $password) {
        $name = mysqli_real_escape_string($this->conn, $name);
        $email = mysqli_real_escape_string($this->conn, $email);
        $phone = mysqli_real_escape_string($this->conn, $phone);
        $password = md5($password);
        
        // Check if email already exists
        if ($this->emailExists($email)) {
            return ['success' => false, 'message' => 'Email already registered!'];
        }
        
        $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
        
        if ($this->conn->query($sql)) {
            return ['success' => true, 'message' => 'Registration successful! Please login.'];
        } else {
            return ['success' => false, 'message' => 'Registration failed!'];
        }
    }

    public function emailExists($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }

    public function getUserById($id) {
        $id = (int)$id;
        $sql = "SELECT name, email, phone FROM users WHERE id = $id";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }
}
?>