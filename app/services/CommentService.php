<?php
require_once __DIR__ . '/../models/Comment.php';

class CommentService {

    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    // Verwerk en sla een nieuwe comment op
    public function addComment($userId, $videoId, $content) {
        $content = trim($content);

        if (empty($content)) {
            return false;
        }

        return $this->commentModel->add($userId, $videoId, $content);
    }

    // Haal alle comments op voor een video
    public function getComments($videoId) {
        return $this->commentModel->getByVideoId($videoId);
    }
}
?>