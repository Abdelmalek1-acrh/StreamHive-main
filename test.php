<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'core/Database.php';
require_once 'app/models/User.php';

$user = new User();
$user->register("TestUser", "test@test.com", "wachtwoord123");
echo "User aangemaakt!";