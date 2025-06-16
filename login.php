<?php
session_name('mys_session');
session_start();

require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/User.php';

use App\Models\User;

$userModel = new User();

$errormessage = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');


    if (empty($email) || empty($password)) {
        $errormessage = 'Please enter both email and password.';
    } else {
        $foundUser = $userModel->findByEmail($email);
        if ($foundUser && $userModel->verifyPassword($password, $foundUser['password'])) {
            // Login success
            $_SESSION['user_id'] = $foundUser['id'];
            $_SESSION['username'] = $foundUser['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $errormessage = 'Invalid email or password.';
        }
    }
}

require_once __DIR__ . '/app/Views/login.view.php';
