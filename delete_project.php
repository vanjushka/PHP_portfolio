<?php
session_name('mys_session');
session_start();

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/Models/Project.php';

use App\Models\Project;

$db = \App\Core\Database::getInstance();
$projectModel = new Project($db);

$id = $_POST['id'] ?? null;

if ($id) {
    $projectModel->delete($id);
}

header('Location: dashboard.php');
exit;
