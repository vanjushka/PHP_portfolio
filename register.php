<?php
session_name('mys_session');
session_start();

require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/app/Models/User.php';

use App\Models\User;

$user = new User();

$successmessage = '';
$errormessage = '';

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize input
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_repeat = trim($_POST['password_repeat'] ?? '');

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($password_repeat)) {
        $errormessage = 'Please fill out all fields.';
    } elseif (strlen($username) < 4 || strlen($username) > 16) {
        $errormessage = 'Username must be between 4 and 16 characters.';
    } elseif (strpos($username, ' ') !== false) {
        $errormessage = 'Username must not contain spaces.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errormessage = 'Please enter a valid email address.';
    } elseif ($password !== $password_repeat) {
        $errormessage = 'Passwords do not match.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[^\s]{8,}$/', $password)) {
        $errormessage = 'Password must be at least 8 characters, include uppercase, lowercase, a number, and a special character. No spaces allowed.';
    } else {
        // Check if username or email already exists
        $existingUser = $user->findByEmail($email);
        if ($existingUser && $existingUser['username'] === $username) {
            $errormessage = 'Username already exists.';
        } elseif ($existingUser) {
            $errormessage = 'Email already exists.';
        } else {
            $success = $user->register($username, $email, $password);
            if ($success) {
                $successmessage = 'Registration successful! You can now <a href="login.php" class="underline text-blue-400">login</a>.';
            } else {
                $errormessage = 'Something went wrong during registration.';
            }
        }
    }
}
require_once __DIR__ . '/app/Views/register.view.php';

