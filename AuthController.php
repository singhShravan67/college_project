<!-- ye bhi ek controller hai jo login, register aur logout handle karta hai -->
<?php
session_start();
require_once 'User.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }

    public function handleLogin() {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = $this->userModel->login($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                return "Invalid email or password!";
            }
        }
        return null;
    }

    public function handleRegister() {
        if (isset($_POST['register'])) {
            $name = $_POST['name'];
            $email = $_POST['reg_email'];
            $phone = $_POST['phone'];
            $password = $_POST['reg_password'];
            
            return $this->userModel->register($name, $email, $phone, $password);
        }
        return null;
    }

    public function logout() {
        if (isset($_GET['logout'])) {
            session_destroy();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUserId() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }

    public function getCurrentUserName() {
        return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
    }
}
?>