<?php
declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/User.php';

use App\Models\User;

$userModel = new User();
$errormessage = '';
$successmessage = '';
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // sanitize
    $username = trim((string)($_POST['username'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = trim((string)($_POST['password'] ?? ''));
    $password_repeat = trim((string)($_POST['password_repeat'] ?? ''));

    // validate
    if ($username === '' || $email === '' || $password === '' || $password_repeat === '') {
        $errormessage = 'Please fill out all fields.';
    } elseif (strlen($username) < 4 || strlen($username) > 16 || strpos($username, ' ') !== false) {
        $errormessage = 'Username must be 4–16 chars with no spaces.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errormessage = 'Please enter a valid email address.';
    } elseif ($password !== $password_repeat) {
        $errormessage = 'Passwords do not match.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[^\s]{8,}$/', $password)) {
        $errormessage = 'Password must be ≥8 chars, include upper, lower, number & special.';
    } else {
        // check email
        if ($userModel->findByEmail($email)) {
            $errormessage = 'Email already exists.';
        } else {
            $ok = $userModel->register($username, $email, $password);
            if ($ok) {
                $successmessage = 'Registration successful! You can now <a href="login.php" class="underline text-blue-400">login</a>.';
                $username = $email = '';
            } else {
                $errormessage = 'Something went wrong during registration.';
            }
        }
    }
}

require_once __DIR__ . '/app/Views/register.view.php';
