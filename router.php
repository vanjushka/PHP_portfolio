<?php
// router.php — use with `php -S localhost:8000 router.php`

if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;

    if ($url !== '/' && is_file($file)) {
        return false;
    }

    // If URL is exactly /
    if ($url === '/' || $url === '/index.php') {
        require __DIR__ . '/index.php';
        return true;
    }

    // Otherwise show custom 404
    require __DIR__ . '/404.php';
}
