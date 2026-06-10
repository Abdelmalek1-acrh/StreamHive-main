<?php
session_start();
require_once '../core/Database.php';
require_once '../app/models/Video.php';
require_once '../app/services/AuthService.php';

$videoModel = new Video();
$authService = new AuthService();
$isLoggedIn = $authService->isLoggedIn();

$query = $_GET['q'] ?? '';
$videos = [];

if (!empty($query)) {
    $videos = $videoModel->search($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Zoeken - StreamHive</title>
</head>
<body>
    <!-- Zoekbalk -->
    <form method="GET" action="search.php">
        <input type="text" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Zoek een video...">
        <button type="submit">Zoeken</button>
    </form>

    <h2>Zoekresultaten voor: "<?= htmlspecialchars($query) ?>"</h2>

    <?php if (empty($query)): ?>
        <p>Typ iets om te zoeken.</p>
    <?php elseif (empty($videos)): ?>
        <p>Geen videos gevonden voor "<?= htmlspecialchars($query) ?>".</p>
    <?php else: ?>
        <?php foreach ($videos as $video): ?>
            <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                <a href="video.php?id=<?= $video['video_id'] ?>">
                    <h3><?= htmlspecialchars($video['title']) ?></h3>
                </a>
                <p>Door: <?= htmlspecialchars($video['username']) ?></p>
                <p><?= htmlspecialchars(substr($video['description'], 0, 100)) ?>...</p>
                <p>👁️ <?= $video['views'] ?> views</p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <br>
    <a href="index.php">← Terug naar home</a>
</body>
</html>