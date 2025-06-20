<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/User.php';

use App\Models\User;

$userModel = new User();
$errormessage = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $errormessage = 'Please enter both email and password.';
    } elseif ($user = $userModel->findByEmail($email)) {
        if ($userModel->verifyPassword($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        }
        $errormessage = 'Invalid email or password.';
    } else {
        $errormessage = 'Invalid email or password.';
    }
}

require __DIR__ . '/app/Views/login.view.php';
