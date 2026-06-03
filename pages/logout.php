<?php
require_once __DIR__ . '/../app/services/AuthService.php';

$authService = new AuthService();
$authService->logout();
?>
