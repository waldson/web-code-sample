<?php
declare(strict_types=1);
namespace W5n\Tests;

use Silex\WebTestCase;
use W5n\Application;

abstract class BaseTest extends WebTestCase
{
    public function createApplication(): Application
    {
        $app = require dirname(dirname(__DIR__)) . '/bootstrap.php';
        $app['debug'] = true;

        return $app;
    }
}
