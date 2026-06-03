<?php
session_start();
require_once '../core/Database.php';
require_once '../app/models/Video.php';

$videoModel = new Video();
$video = $videoModel->getById($_GET['id'] ?? 0);

if (!$video) {
    die("Video niet gevonden.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $video['title'] ?> - StreamHive</title>
</head>
<body>
    <h1><?= $video['title'] ?></h1>
    <p>Geüpload door: <?= $video['username'] ?></p>
    <p><?= $video['description'] ?></p>
    <video width="720" controls>
        <source src="../upload/<?= $video['url'] ?>" type="video/mp4">
    </video>
    <br>
    <a href="index.php">← Terug naar overzicht</a>
</body>
</html>