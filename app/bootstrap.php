<?php

if (session_status() === PHP_SESSION_NONE) {
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => $_SERVER['SERVER_NAME'],
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);

    session_name('mys_session');
    session_start();
}
