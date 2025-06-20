<?php
session_name('mys_session');
session_start();

require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/UploadHandler.php';

use App\Core\Database;

// Use your singleton DB connection
$db = Database::getInstance();
$uploader = new UploadHandler($db);

// Handle upload POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['image'], $_POST['alt'])) {
        $_SESSION['upload_errors'] = ['Please provide an image and an alt text.'];
        header('Location: dashboard.php');
        exit;
    }

    $path = $uploader->upload($_FILES['image'], $_POST['alt']);

    if (!empty($uploader->errors)) {
        $_SESSION['upload_errors'] = $uploader->errors;
    } else {
        $_SESSION['upload_success'] = "Image uploaded successfully.";
    }

    header('Location: dashboard.php');
    exit;
}