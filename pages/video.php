<?php
session_start();
require_once '../core/Database.php';
require_once '../app/models/Video.php';
require_once '../app/models/Like.php';
require_once '../app/services/CommentService.php';
require_once '../app/services/AuthService.php';

$videoModel = new Video();
$likeModel = new Like();
$commentService = new CommentService();
$authService = new AuthService();

$videoId = $_GET['id'] ?? 0;
$video = $videoModel->getById($videoId);

if (!$video) {
    die("Video niet gevonden.");
}

$videoModel->incrementViews($videoId);

$isLoggedIn = $authService->isLoggedIn();
$userId = $_SESSION['user_id'] ?? null;

// Verwerk like/unlike/comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (!$isLoggedIn) {
        header('Location: login.php');
        exit();
    }

    if ($_POST['action'] === 'like') {
        $likeModel->add($userId, $videoId);
    } elseif ($_POST['action'] === 'unlike') {
        $likeModel->remove($userId, $videoId);
    } elseif ($_POST['action'] === 'comment' && !empty($_POST['content'])) {
        $commentService->addComment($userId, $videoId, $_POST['content']);
    }

    header('Location: video.php?id=' . $videoId);
    exit();
}

// Haal likes en comments op
$likeCount = $likeModel->countByVideoId($videoId);
$hasLiked = $isLoggedIn ? $likeModel->hasLiked($userId, $videoId) : false;
$comments = $commentService->getComments($videoId);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($video['title']) ?> - StreamHive</title>
</head>
<body>
    <h1><?= htmlspecialchars($video['title']) ?></h1>
    <p>Geüpload door: <?= htmlspecialchars($video['username']) ?></p>
    <p>👁️ <?= $video['views'] ?> views</p>
    <p><?= htmlspecialchars($video['description']) ?></p>

    <video width="720" controls>
        <source src="../public/<?= htmlspecialchars($video['url']) ?>" type="video/mp4">
    </video>

    <br><br>

    <!-- Like knop -->
    <form method="POST">
        <?php if ($hasLiked): ?>
            <button type="submit" name="action" value="unlike">👎 Unlike (<?= $likeCount ?>)</button>
        <?php else: ?>
            <button type="submit" name="action" value="like">👍 Like (<?= $likeCount ?>)</button>
        <?php endif; ?>
    </form>

    <br>

    <!-- Comments sectie -->
    <h2>Comments (<?= count($comments) ?>)</h2>

    <?php if ($isLoggedIn): ?>
        <form method="POST">
            <textarea name="content" placeholder="Schrijf een comment..." rows="3" cols="50"></textarea>
            <br>
            <button type="submit" name="action" value="comment">Plaatsen</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Log in</a> om een comment te plaatsen.</p>
    <?php endif; ?>

    <br>

    <?php if (empty($comments)): ?>
        <p>Nog geen comments. Wees de eerste!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                <strong><?= htmlspecialchars($comment['username']) ?></strong>
                <span style="color: grey; font-size: 0.8em;">
                    <?= $comment['posted_at'] ?>
                </span>
                <p><?= htmlspecialchars($comment['content']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <br>
    <a href="index.php">← Terug naar overzicht</a>
</body>
</html>