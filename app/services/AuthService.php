<?php
require_once __DIR__ . '/../models/User.php';

class AuthService {

    private $userModel;

    // public function is een functie die iedereen kan gebruiken
    public function __construct() {
        $this->userModel = new User();
    }

    // Registreren
    public function register($username, $email, $password) {
        return $this->userModel->register($username, $email, $password);
    }

    // Inloggen - haalt user op uit database en start sessie
    public function login($email, $password) {
        $user = $this->userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }

        return false;
    }

    // Uitloggen - vernietigt de sessie
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: login.php');
        exit;
    }

    // Checkt of iemand ingelogd is
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>