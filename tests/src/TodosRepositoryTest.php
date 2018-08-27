<?php
declare(strict_types=1);

namespace W5n\Tests;

use W5n\Repositories\TodosRepository;
use Doctrine\DBAL\Connection;

class TodosRepositoryTest extends BaseTest
{
    private function createRepository(): TodosRepository
    {
        return new TodosRepository(
            $this->getConnection()
        );
    }

    private function getConnection(): Connection
    {
        return $this->app['db'];
    }

    private function createRandomItem(): array
    {
        //not really an uuid
        $uuid = uniqid('uuid');

        $completed   = rand(0, 100) % 2 == 0;
        $completedAt = $completed ? date('Y-m-d H:i:s') : null;

        return [
            'text'         => $uuid,
            'uuid'         => $uuid,
            'created_at'   => date('Y-m-d H:i:s'),
            'completed'    => $completed,
            'completed_at' => $completedAt
        ];
    }

    public function testFetch(): void
    {
        $repository = $this->createRepository();
        $todos      = $repository->getTodos();
        $this->assertTrue(is_array($todos));
    }

    public function testInsert(): void
    {
        $repository = $this->createRepository();
        $item       = $this->createRandomItem();

        $this->assertTrue($repository->insert($item));
    }

    public function testFind(): void
    {
        $repository = $this->createRepository();
        $item       = $this->createRandomItem();
        $repository->insert($item);

        $newItem = $repository->find($item['uuid']);
        $this->assertEquals($item, $newItem);
    }

    public function testUpdate(): void
    {
        $repository = $this->createRepository();
        $item       = $this->createRandomItem();
        $repository->insert($item);
        $item['completed'] = !$item['completed'];
        $this->assertTrue($repository->update($item['uuid'], $item));
    }

    public function testDelete(): void
    {
        $repository = $this->createRepository();
        $item       = $this->createRandomItem();
        $repository->insert($item);
        $this->assertTrue($repository->delete($item['uuid']));
    }

    public function testDontInsertEmptyItem(): void
    {
        $repository = $this->createRepository();
        $this->assertFalse($repository->insert([]));
    }

    public function testDontUpdateEmptyItem(): void
    {
        $repository = $this->createRepository();
        $this->assertFalse($repository->update('uuid', []));
    }

    public function testDontUpdateEmptyUuid(): void
    {
        $repository = $this->createRepository();
        $this->assertFalse(
            $repository->update(
                '',
                ['uuid' => 'test', 'text' => 'test']
            )
        );
    }
}
