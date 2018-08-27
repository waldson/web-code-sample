<?php
declare(strict_types=1);

namespace W5n\Tests;

use W5n\Application;

class ApplicationTest extends BaseTest
{
    public function createApplication(): Application
    {
        $app = require dirname(dirname(__DIR__)) . '/bootstrap.php';
        $app['debug'] = true;

        return $app;
    }

    public function testAppPage(): void
    {
        $client  = $this->createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testTodosEndpoint(): void
    {
        $client  = $this->createClient();
        $client->request('GET', '/todos');

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testInsertEndpoint(): void
    {
        $client  = $this->createClient();
        $client->request('POST', '/todos');

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testUpdateEndpoint(): void
    {
        $client  = $this->createClient();
        $client->request('PUT', '/todos/uuid');

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testDeleteEndpoint(): void
    {
        $client  = $this->createClient();
        $client->request('DELETE', '/todos/uuid');

        $this->assertTrue($client->getResponse()->isOk());
    }
}
