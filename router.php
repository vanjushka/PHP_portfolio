<?php
// router.php for `php -S`

if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;

    // 1) If it’s a real file (CSS, JS, image, or PHP), let PHP built-in server handle it
    if ($url !== '/' && is_file($file)) {
        return false;
    }

    // 2) Otherwise, route everything through your 404 page
    require __DIR__ . '/404.php';
}
