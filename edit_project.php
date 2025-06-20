<?php
session_name('mys_session');
session_start();

use App\Core\Database;
use App\Models\Project;

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/Models/Project.php';
require_once __DIR__ . '/UploadHandler.php';

$db = Database::getInstance();
$projectModel = new Project();
$uploader = new UploadHandler($db);

$id = (int)($_REQUEST['id'] ?? 0);
if (!$id) {
    header('Location: dashboard.php');
    exit;
}

$project = $projectModel->getById($id);
if (!$project) {
    header('Location: dashboard.php');
    exit;
}

$errormessage = '';
$successmessage = '';

// Handle both delete-image and standard updates in one POST block
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Delete Image
    if (!empty($_POST['delete_image'])) {
        if (!empty($project['image'])) {
            $path = __DIR__ . '/' . $project['image'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
        // Clear DB image field
        $projectModel->updateImage($id, null);
        $successmessage = 'Image deleted successfully.';
        // Refresh project
        $project = $projectModel->getById($id);
    } // 2) Standard Update (title, desc, company, link, optional new upload)
    else {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $link = trim($_POST['link'] ?? '');
        $imagePath = $project['image'];

        if (empty($title) || empty($description)) {
            $errormessage = 'Title and description are required.';
        } else {
            // Handle new upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $newPath = $uploader->upload($_FILES['image'], $title, $id);
                if (!empty($uploader->errors)) {
                    $errormessage = implode(', ', $uploader->errors);
                } else {
                    // delete old file
                    if (!empty($imagePath) && file_exists(__DIR__ . '/' . $imagePath)) {
                        unlink(__DIR__ . '/' . $imagePath);
                    }
                    $imagePath = $newPath;
                }
            }

            if (empty($errormessage)) {
                $updated = $projectModel->update($id, $title, $description, $company, $imagePath, $link);
                if ($updated) {
                    $successmessage = 'Project updated successfully!';
                    $project = $projectModel->getById($id);
                } else {
                    $errormessage = 'Failed to update project.';
                }
            }
        }
    }
}

require_once __DIR__ . '/app/Views/edit_project.view.php';
