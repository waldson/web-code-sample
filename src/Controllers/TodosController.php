<?php
declare(strict_types=1);

namespace W5n\Controllers;

use W5n\Application;
use Twig_Environment;
use W5n\Repositories\TodosRepository;

class TodosController
{
    private $twig = null;
    private $repository = null;

    public function __construct(Twig_Environment $twig, TodosRepository $repository)
    {
        $this->twig       = $twig;
        $this->repository = $repository;
    }

    public function index(): string
    {
        return $this->twig->render('app.twig.php');
    }

    public function fetch(): array
    {
        $data = $this->repository->getTodos();
        return $data;
    }

    public function insert(array $item): array
    {
        $result = $this->repository->insert($item);
        return ['success' => $result];
    }

    public function update(string $uuid, array $item): array
    {
        $result = $this->repository->update($uuid, $item);
        return ['success' => $result];
    }

    public function delete(string $uuid): array
    {
        $result = $this->repository->delete($uuid);
        return ['success' => $result];
    }
}
