<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
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

spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $len = strlen($prefix);


    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }


    $relativeClass = substr($class, $len);
    $relativePath = str_replace('\\', '/', $relativeClass) . '.php';


    $fileApp = __DIR__ . '/' . $relativePath;
    $fileRoot = __DIR__ . '/../' . $relativePath;

    if (file_exists($fileApp)) {
        require $fileApp;
    } elseif (file_exists($fileRoot)) {
        require $fileRoot;
    }
});

require_once __DIR__ . '/../config/config.php';
