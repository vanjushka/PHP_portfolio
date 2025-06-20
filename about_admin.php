<?php
declare(strict_types=1);

// 1) Bootstrap (SameSite session, etc.)
require_once __DIR__ . '/app/bootstrap.php';

// 2) Core & Model
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/AboutSection.php';
require_once __DIR__ . '/UploadHandler.php';

use App\Models\AboutSection;
use App\Core\Database;

// 3) Initialize
$model = new AboutSection();
$err = '';
$succ = '';
$editing = null;

// 4) Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 4a) Reorder Sections
    if (isset($_POST['action']) && $_POST['action'] === 'reorder' && !empty($_POST['order'])) {
        foreach ((array)$_POST['order'] as $newIndex => $sectionId) {
            $model->updateSortOrder((int)$sectionId, (int)$newIndex);
        }
        $succ = 'Sections reordered successfully.';

        // 4b) Delete Section
    } elseif (!empty($_POST['delete']) && !empty($_POST['id'])) {
        $id = (int)$_POST['id'];
        // remove image file if exists
        $sec = $model->getById($id);
        if ($sec && !empty($sec['image']) && file_exists(__DIR__ . '/' . $sec['image'])) {
            unlink(__DIR__ . '/' . $sec['image']);
        }
        $model->delete($id);
        $succ = 'Section deleted successfully.';

        // 4c) Add or Update Section
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $delete = !empty($_POST['delete']);
        $image = null;

        // If updating, load existing for sort_order & old image
        if ($id) {
            $existing = $model->getById($id);
            if ($existing) {
                $image = $existing['image'];
                $sort = (int)$existing['sort_order'];
            }
        }

        // Handle “remove image” checkbox
        if ($delete && $image) {
            if (file_exists(__DIR__ . '/' . $image)) {
                unlink(__DIR__ . '/' . $image);
            }
            $image = null;
        }

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploader = new UploadHandler(Database::getInstance());
            $newPath = $uploader->upload($_FILES['image'], $title);
            if (!empty($uploader->errors)) {
                $err = implode(', ', $uploader->errors);
            } else {
                // delete old if replacing
                if (!empty($image) && file_exists(__DIR__ . '/' . $image)) {
                    unlink(__DIR__ . '/' . $image);
                }
                $image = $newPath;
            }
        }

        // Only proceed if no upload error
        if (!$err) {
            if ($id) {
                // Update existing
                $updated = $model->update($id, $title, $content, $image, $sort);
                $succ = $updated
                    ? 'Section updated successfully.'
                    : 'Failed to update section.';
                $editing = $model->getById($id);
            } else {
                // Add new (append to end)
                $maxSort = count($model->getAll());
                $added = $model->add($title, $content, $image, $maxSort);
                $succ = $added
                    ? 'Section added successfully.'
                    : 'Failed to add section.';
            }
        }
    }
}

// 5) If clicking “Edit”, load that section
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_GET['id'])) {
    $editing = $model->getById((int)$_GET['id']);
}

// 6) Fetch all for display (ordered by sort_order)
$sections = $model->getAll();

// 7) Show the view
require_once __DIR__ . '/app/Views/about_admin.view.php';
