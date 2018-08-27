<?php
declare(strict_types=1);

namespace W5n\Repositories;

use \Doctrine\Dbal\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class TodosRepository
{
    private $connection = null;
    private $table      = 'todos';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    private function createQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }

    public function getTodos(): array
    {
        return $this->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->orderBy('created_at', 'DESC')
            ->execute()->fetchAll();
    }

    public function insert(array $item): bool
    {
        if (empty($item['uuid']) || empty($item['text'])) {
            return false;
        }

        $keys   = [];
        foreach (array_keys($item) as $key) {
            $keys[$key] = ':' . $key;
        }

        try {
            $result = $this->createQueryBuilder()
                ->insert($this->table)
                ->values($keys)
                ->setParameters($item)
                ->execute();
            return $result == 1;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function update(string $uuid, array $item): bool
    {
        if (empty($item['uuid']) || empty($uuid) || empty($item['text'])) {
            return false;
        }

        try {
            $query = $this->createQueryBuilder()->update($this->table);

            foreach ($item as $key => $value) {
                if ($key == 'uuid') {
                    continue;
                }
                $query->set($key, $query->createNamedParameter($value));
            }
            $query->where('uuid=' . $query->createNamedParameter($uuid));
            $result = $query->execute();
            return $result == 1;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function delete(string $uuid): bool
    {
        try {
            $query = $this->createQueryBuilder()->delete($this->table);
            $query->where('uuid=' . $query->createNamedParameter($uuid));
            $result = $query->execute();
            return $result == 1;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function find(string $uuid): ?array
    {
        $query = $this->createQueryBuilder();
        return $query
            ->select('*')
            ->from($this->table)
            ->where('uuid=:uuid')
            ->setParameter('uuid', $uuid)
            ->execute()->fetch();
    }
}
