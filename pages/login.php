<?php require_once __DIR__ . '/../app/services/AuthService.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - hive</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

    <?php
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $auth = new AuthService();
        $result = $auth->login(
             $_POST['email'],
             $_POST['password']
        );
        
        
        if ($result) {
            header('Location: index.php');
            exit();
        } else {
            echo 'Login failed.';
        }
     }
    ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p>Geen account? <a href="register.php">Register</a>



    </div>
</body>
</html>