<?php
require_once __DIR__ . '/../../core/Database.php';

class Video {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    // Video opslaan in database
    public function upload($userId, $title, $description, $videoPath, $thumbnailPath) {
        $sql = "INSERT INTO videos (user_id, title, description, url, thumbnail, uploaded_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $title, $description, $videoPath, $thumbnailPath]);
    }

    // Alle videos ophalen voor mainpage
    public function getAllVideos() {
        $sql = "SELECT v.*, u.username FROM videos v JOIN users u ON v.user_id = u.user_id ORDER BY v.uploaded_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Video ophalen via ID
    public function getById($videoId) {
        $sql = "SELECT v.*, u.username FROM videos v JOIN users u ON v.user_id = u.user_id WHERE v.video_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$videoId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Videos ophalen van een specifieke user
    public function getByUserId($userId) {
        $sql = "SELECT * FROM videos WHERE user_id = ? ORDER BY uploaded_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>