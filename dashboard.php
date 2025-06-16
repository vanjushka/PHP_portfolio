<?php
session_name('mys_session');
session_start();

// If user is not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen p-8">
<h1 class="text-3xl font-bold mb-4">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
<p class="mb-4">This is your protected dashboard.</p>

<a href="logout.php" class="text-blue-400 underline">Logout</a>
</body>
</html>
