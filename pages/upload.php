<?php session_start(); ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload - StreamHive</title>
    <link rel="stylesheet" href="../css/Style.css">
</head>
<body>
<?php
require_once __DIR__ . '/../app/services/VideoService.php';
require_once __DIR__ . '/../app/services/AuthService.php';

// Controleer of de gebruiker ingelogd is
$authService = new AuthService();
if (!$authService->isLoggedIn()){
    header('location: login.php');
    exit();
}

// Als het formulier is ingediend, upload de video
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $videoService = new VideoService();
    // Stuur gebruiker ID, titel, beschrijving, video en thumbnail naar de service
    $videoService->uploadVideo(
        $_SESSION['user_id'],
        $_POST['title'],
        $_POST['description'],
        $_FILES['video'],
        $_FILES['thumbnail']
    );
}
?>

    <!-- Upload formulier met enctype voor bestanden -->
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Titel">
        <input type="text" name="description" placeholder="Beschrijving">
        <input type="file" name="video">
        <input type="file" name="thumbnail">
        <button type="submit">Upload</button>
    </form>
</body>
</html>