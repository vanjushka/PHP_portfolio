<?php
session_name('mys_session');
session_start();

// Clear session and destroy
$_SESSION = [];
session_destroy();

// Redirect to login page
header('Location: login.php');
exit;
