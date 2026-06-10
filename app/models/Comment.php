<?php
require_once __DIR__ . '/../../core/Database.php';

class Comment {

    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    // Haalt alle comments op voor deze video, inclusief wie het geschreven heeft (met username via JOIN)
    public function getByVideoId($videoId) {
        $sql = "SELECT c.*, u.username 
                FROM comments c 
                JOIN users u ON c.user_id = u.user_id 
                WHERE c.video_id = ? 
                ORDER BY c.posted_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$videoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nieuwe comment opslaan
    public function add($userId, $videoId, $content) {
        $sql = "INSERT INTO comments (user_id, video_id, content) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $videoId, $content]);
    }
}
?>