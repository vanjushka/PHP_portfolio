<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Database;
use App\Logic\UploadHandler;

// Redirect
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

if (empty($_FILES['image']) || empty($_POST['alt'])) {
    $_SESSION['upload_errors'] = ['Please provide an image and an alt text.'];
    header('Location: dashboard.php');
    exit;
}

// Handle upload
$db = Database::getInstance();
$uploader = new UploadHandler($db);
$altText = trim($_POST['alt']);

$path = $uploader->upload($_FILES['image'], $altText);

//Save result in session
if (!empty($uploader->errors)) {
    $_SESSION['upload_errors'] = $uploader->errors;
} else {
    $_SESSION['upload_success'] = 'Image uploaded successfully.';
}

header('Location: dashboard.php');
exit;
