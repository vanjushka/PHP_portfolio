<?php
declare(strict_types=1);

session_name('mys_session');
session_start();

// Redirect unless valid project id
$id = (int)($_REQUEST['id'] ?? 0);
if ($id <= 0) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/Project.php';
require_once __DIR__ . '/app/Logic/UploadHandler.php';

use App\Core\Database;
use App\Models\Project;


$db = Database::getInstance();
$projectModel = new Project();
$uploader = new UploadHandler($db);

// Load the project or exit
$project = $projectModel->getById($id);
if (!$project) {
    header('Location: dashboard.php');
    exit;
}

$errormessage = '';
$successmessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Delete existing image?
    if (!empty($_POST['delete_image'])) {
        if (!empty($project['image'])) {
            $fullPath = __DIR__ . '/' . $project['image'];
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
        $projectModel->updateImage($id, null);
        $successmessage = 'Image removed.';
        // reload fresh data
        $project = $projectModel->getById($id);

    } else {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $link = trim($_POST['link'] ?? '');
        $imagePath = $project['image'];

        if ($title === '' || $description === '') {
            $errormessage = 'Title & description required.';
        } else {
            // maybe upload a new image
            if (
                isset($_FILES['image']) &&
                $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
            ) {
                $newPath = $uploader->upload(
                    $_FILES['image'],
                    $title,
                    $id
                );
                if (!empty($uploader->errors)) {
                    $errormessage = implode(', ', $uploader->errors);
                } else {
                    // delete old file
                    if ($imagePath && file_exists(__DIR__ . '/' . $imagePath)) {
                        unlink(__DIR__ . '/' . $imagePath);
                    }
                    $imagePath = $newPath;
                }
            }

            // update record
            if ($errormessage === '') {
                $ok = $projectModel->update(
                    $id,
                    $title,
                    $description,
                    $company ?: null,
                    $imagePath ?: null,
                    $link ?: null
                );
                if ($ok) {
                    $successmessage = 'Project updated.';
                    $project = $projectModel->getById($id);
                } else {
                    $errormessage = 'Update failed.';
                }
            }
        }
    }
}

require_once __DIR__ . '/app/Views/edit_project.view.php';
