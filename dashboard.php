<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';


use App\Core\Database;
use App\Models\Project;

// 1) If not logged in, go to login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 2) Pull in your core
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Project.php';
require_once __DIR__ . '/UploadHandler.php';

// 3) Set up DB + uploader + model
$db = Database::getInstance();
$uploader = new UploadHandler($db);
$projectModel = new Project();

$errormessage = '';
$successmessage = '';

// 4) Handle form submission & debug
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DEBUG: show raw POST data
    $errormessage = 'DEBUG — POST payload: ' . htmlspecialchars(json_encode($_POST));

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $link = trim($_POST['link'] ?? '');

    if (empty($title) || empty($description)) {
        $errormessage = 'Title and description are required.';
    } else {
        $added = $projectModel->add($title, $description, $company ?: null, null, $link ?: null);

        if (!$added) {
            $info = $db->errorInfo();
            $errormessage = 'DB Insert failed: ' . implode(' | ', $info);
        } else {
            $successmessage = '✔ Project added successfully!';
        }
    }
}

// 5) Fetch projects
$projects = $projectModel->getAll();

// 6) Render header partial
$pageTitle = 'Dashboard — Vanja Dunkel';
require __DIR__ . '/app/Views/partials/header.php';

// 7) Render the view itself
require __DIR__ . '/app/Views/dashboard.view.php';

// 8) Render footer partial
require __DIR__ . '/app/Views/partials/footer.php';
