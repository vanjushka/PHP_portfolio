<?php
// logout.php
declare(strict_types=1);

// Use your bootstrap to handle the session name & start
require_once __DIR__ . '/app/bootstrap.php';

// Clear & destroy
$_SESSION = [];
session_destroy();

// Redirect back to login with a flag
header('Location: login.php?logged_out=1');
exit;
