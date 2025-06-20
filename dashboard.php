<?php
declare(strict_types=1);

// 1) Bootstrap — session setup
require_once __DIR__ . '/app/bootstrap.php';

// 2) Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 3) Autoload core classes
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Project.php';

// 4) UploadHandler lives under app/Logic now
require_once __DIR__ . '/app/Logic/UploadHandler.php';

use App\Core\Database;
use App\Models\Project;
use App\Logic\UploadHandler;

// 5) Init
$db = Database::getInstance();
$uploader = new UploadHandler($db);
$projectModel = new Project();

$errormessage = '';
$successmessage = '';

// 6) Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $link = trim($_POST['link'] ?? '');

    if ($title === '' || $description === '') {
        $errormessage = 'Title and description are required.';
    } else {
        $added = $projectModel->add(
            $title,
            $description,
            $company ?: null,
            null,
            $link ?: null
        );

        if (!$added) {
            $info = $db->errorInfo();
            $errormessage = 'DB Insert failed: ' . implode(' | ', $info);
        } else {
            $successmessage = '✔ Project added successfully!';
        }
    }
}

// 7) Fetch all projects
$projects = $projectModel->getAll();

// 8) Render header + view + footer
$pageTitle = 'Dashboard — Vanja Dunkel';
require __DIR__ . '/app/Views/partials/header.php';
require __DIR__ . '/app/Views/dashboard.view.php';
require __DIR__ . '/app/Views/partials/footer.php';
