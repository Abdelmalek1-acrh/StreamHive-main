<?php
require_once __DIR__ . '/../models/User.php';

class AuthService {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Registreren
    public function register($username, $email, $password) {
        return $this->userModel->register($username, $email, $password);
    }

    // Inloggen
    public function login($email, $password) {
        $user = $this->userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }

        return false;
    }

    // Uitloggen
    public function logout() {
        session_start();
        session_destroy();
        header('Location: login.php');
        exit;
    }

    // Checkt of iemand ingelogd is
    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['user_id']);
    }
}
?>