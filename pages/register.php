<?php
session_start();
require_once '../core/Database.php';
require_once '../app/models/User.php';
require_once '../app/services/AuthService.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $auth = new AuthService();
    $result = $auth->register($username, $email, $password);

    if ($result) {
        $success = "Account aangemaakt! Je kan nu inloggen.";
    } else {
        $error = "Er ging iets mis, probeer opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registreren - StreamHive</title>
</head>
<body>
    <h1>Registreren</h1>

    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Gebruikersnaam" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br>
        <button type="submit">Registreren</button>
    </form>

    <a href="login.php">Al een account? Inloggen</a>
</body>
</html>