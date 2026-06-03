<?php
require_once __DIR__ . '/../core/Database.php';

$db = Database::getInstance();

if ($db) {
    echo "Database connectie werkt!";
} else {
    echo "Connectie mislukt!";
}
?>