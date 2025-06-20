<?php

// Only configure & start the session if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    // Set SamebSite & params before starting
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);

    session_name('mys_session');
    session_start();
}
