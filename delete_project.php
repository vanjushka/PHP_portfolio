<?php
session_name('mys_session');
session_start();

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Project.php';

use App\Core\Database;
use App\Models\Project;

$db = Database::getInstance();
$projectModel = new Project();
$id = (int)($_POST['id'] ?? 0);

if ($id) {
    $projectModel->delete($id);
}

header('Location: dashboard.php');
exit;
