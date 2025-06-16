<?php
require_once __DIR__ . '/app/core/Database.php';

use App\Core\Database;

$pdo = Database::getInstance();
echo "Connected to database!";
