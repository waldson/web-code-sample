<?php
$app = require_once dirname(__DIR__) . '/bootstrap.php';
if ($app === false) {
    return $app;
}
$app->run();
