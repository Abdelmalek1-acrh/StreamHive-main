<?php
session_start();
require_once __DIR__ . '/../app/models/Video.php';
require_once __DIR__ . '/../app/services/AuthService.php';

$videoModel = new Video();
$authService = new AuthService();
$videos = $videoModel->getAllVideos();
$isLoggedIn = $authService->isLoggedIn();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StreamHive - Home</title>
    <link rel="stylesheet" href="../css/Style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">StreamHive</a>
            <div class="nav-links">
                <?php if ($isLoggedIn): ?>
                    <a href="upload.php" class="nav-link">Upload</a>
                    <a href="profile.php" class="nav-link">Profiel</a>
                    <a href="logout.php" class="nav-link">Uitloggen</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Inloggen</a>
                    <a href="register.php" class="nav-link">Registreren</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="hero">
            <h1>Welkom bij StreamHive</h1>
            <p>Deel je video's met de wereld</p>
        </div>

        <div class="video-grid">
            <?php if (empty($videos)): ?>
                <div class="no-videos">
                    <p>Er zijn nog geen videos. <a href="upload.php">Upload de eerste video!</a></p>
                </div>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-card">
                        <a href="video.php?id=<?php echo $video['video_id']; ?>" class="video-link">
                            <div class="thumbnail">
                                <img src="<?php echo htmlspecialchars($video['thumbnail_path']); ?>" alt="<?php echo htmlspecialchars($video['title']); ?>">
                            </div>
                            <div class="video-info">
                                <h3><?php echo htmlspecialchars($video['title']); ?></h3>
                                <p class="username">Door <?php echo htmlspecialchars($video['username']); ?></p>
                                <p class="description"><?php echo htmlspecialchars(substr($video['description'], 0, 100)); ?>...</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>