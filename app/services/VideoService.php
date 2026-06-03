<?php
require_once __DIR__ . '/../models/Video.php';

class VideoService {

    private $videoModel;

    public function __construct() {
        $this->videoModel = new Video();
    }

    // Video uploaden met file handling
    public function uploadVideo($userId, $title, $description, $videoFile, $thumbnailFile) {
        // Upload directories
        $videoDir = __DIR__ . '/../../public/uploads/videos/';
        $thumbnailDir = __DIR__ . '/../../public/uploads/thumbnails/';
        
        // Maak directories als ze niet bestaan
        if (!file_exists($videoDir)) {
            mkdir($videoDir, 0777, true);
        }
        if (!file_exists($thumbnailDir)) {
            mkdir($thumbnailDir, 0777, true);
        }

        // Video file upload
        $videoName = time() . '_' . basename($videoFile['name']);
        $videoPath = 'uploads/videos/' . $videoName;
        move_uploaded_file($videoFile['tmp_name'], $videoDir . $videoName);

        // Thumbnail file upload
        $thumbnailName = time() . '_' . basename($thumbnailFile['name']);
        $thumbnailPath = 'uploads/thumbnails/' . $thumbnailName;
        move_uploaded_file($thumbnailFile['tmp_name'], $thumbnailDir . $thumbnailName);

        // Opslaan in database
        return $this->videoModel->upload($userId, $title, $description, $videoPath, $thumbnailPath);
    }
}
?>