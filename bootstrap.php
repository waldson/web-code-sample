<?php
require_once __DIR__ . '/vendor/autoload.php';

if (isset($_SERVER['REQUEST_URI'])) {
    $path     = preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    $filename = __DIR__ . '/public/' . $path;

    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
        return false;
    }
}

$env    = isset($_ENV['env']) ? $_ENV['env'] : 'production';
$isTest = $env == 'test';
$path   = __DIR__ . '/resources/data/todos.sqlite';

if ($isTest) {
    $path   = __DIR__ . '/resources/data/todos.test.sqlite';
    if (file_exists($path)) {
        unlink($path);
    }
}

$app = new W5n\Application(
    $env,
    __DIR__ . '/resources',
    $path,
    __DIR__ . '/resources/data/db-template.sqlite'
);

return $app;
