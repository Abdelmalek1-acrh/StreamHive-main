<?php
require_once __DIR__ . '/../../core/Database.php';

class User {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    // Nieuwe user opslaan
    public function register($username, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$username, $email, $hash]);
    }
   
    // User ophalen via email (voor inloggen)
    public function getByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // User ophalen via ID (voor profiel)
    public function getById($id) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>