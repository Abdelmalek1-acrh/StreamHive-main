<?php
require_once __DIR__ . '/../../core/Database.php';

class Like {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }

    // Voeg een like toe aan een video
    public function add($userId, $videoId) {
        $sql = "INSERT IGNORE INTO likes (user_id, video_id) VALUES (?, ?)"; // Ignore als de combinatie al bestaat, zodat er geen dubbele likes kunnen worden toegevoegd
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $videoId]);
    }

    // Verwijder een like van een video
    public function remove($userId, $videoId) {
        $sql = "DELETE FROM likes WHERE user_id = ? AND video_id = ?"; // Verwijdert de like
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $videoId]);
    }

    // Controleer of een user al geliked heeft
    public function hasLiked($userId, $videoId) {
        $sql = "SELECT like_id FROM likes WHERE user_id = ? AND video_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId, $videoId]);
        return $stmt->fetch() !== false;
    }

    // Tel het aantal likes voor een video
    public function countByVideoId($videoId) {
        $sql = "SELECT COUNT(*) as total FROM likes WHERE video_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$videoId]);
        return $stmt->fetch()['total'];
    }
}
?>