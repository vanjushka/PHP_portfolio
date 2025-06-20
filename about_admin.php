<?php
declare(strict_types=1);


require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/AboutSection.php';
require_once __DIR__ . '/app/Logic/UploadHandler.php';

use App\Core\Database;
use App\Models\AboutSection;
use App\Logic\UploadHandler;


$model = new AboutSection();
$err = '';
$succ = '';
$editing = null;

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Reorder Sections
    if (!empty($_POST['action'])
        && $_POST['action'] === 'reorder'
        && !empty($_POST['order'])
        && is_array($_POST['order'])
    ) {
        foreach ($_POST['order'] as $newIndex => $sectionId) {
            $model->updateSortOrder((int)$sectionId, (int)$newIndex);
        }
        $succ = 'Sections reordered successfully.';

        // Delete Section
    } elseif (!empty($_POST['delete']) && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        $sec = $model->getById($id);
        if ($sec && !empty($sec['image'])) {
            $path = __DIR__ . '/' . $sec['image'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $model->delete($id);
        $succ = 'Section deleted successfully.';

        //Add or Update Section
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $remove = !empty($_POST['delete']);
        $sort = 0;
        $image = null;

        // pull existing for sort & image
        if ($id) {
            $existing = $model->getById($id);
            if ($existing) {
                $sort = (int)$existing['sort_order'];
                $image = $existing['image'];
            }
        }

        // remove image if requested
        if ($remove && $image) {
            $file = __DIR__ . '/' . $image;
            if (file_exists($file)) {
                unlink($file);
            }
            $image = null;
        }

        // handle new upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploader = new UploadHandler(Database::getInstance());
            $newPath = $uploader->upload($_FILES['image'], $title);
            if (!empty($uploader->errors)) {
                $err = implode(', ', $uploader->errors);
            } else {
                // delete old file if replaced
                if ($image && file_exists(__DIR__ . '/' . $image)) {
                    unlink(__DIR__ . '/' . $image);
                }
                $image = $newPath;
            }
        }

        // proceed only if no upload error
        if (!$err) {
            if ($id) {
                $updated = $model->update($id, $title, $content, $image, $sort);
                $succ = $updated ? 'Section updated successfully.' : 'Failed to update section.';
                $editing = $model->getById($id);
            } else {
                $maxSort = count($model->getAll());
                $added = $model->add($title, $content, $image, $maxSort);
                $succ = $added ? 'Section added successfully.' : 'Failed to add section.';
            }
        }
    }
}

// Edit clicked via GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !empty($_GET['id'])) {
    $editing = $model->getById((int)$_GET['id']);
}


$sections = $model->getAll();


require_once __DIR__ . '/app/Views/about_admin.view.php';
