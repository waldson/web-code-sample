<?php
declare(strict_types=1);

namespace W5n;

use Silex\Application as BaseApp;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use W5n\Controllers\TodosController;
use W5n\Repositories\TodosRepository;
use Symfony\Component\HttpFoundation\Request;

class Application extends BaseApp
{
    private $resourcesPath  = null;
    private $dbPath         = null;
    private $dbTemplatePath = null;

    public function __construct(
        string $environment,
        string $resourcesPath,
        string $dbPath,
        string $dbTemplatePath,
        array $values = []
    ) {
        parent::__construct($values);
        $this->resourcesPath  = rtrim($resourcesPath, '/');
        $this->dbPath         = $dbPath;
        $this->dbTemplatePath = $dbTemplatePath;

        $this['debug']       = true;
        $this['environment'] = $environment;
        $this->configure();
    }

    private function configure(): void
    {
        $this->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type', ''), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });

        $this->registerServices();
        $this->initDb();
        $this->initRoutes();
    }

    private function initDb(): void
    {
        if (!file_exists($this->dbPath)) {
            copy($this->dbTemplatePath, $this->dbPath);
        }
    }

    private function registerServices(): void
    {
        $this->register(new TwigServiceProvider(), [
            'twig.path' => $this->resourcesPath . '/views'
        ]);

        $this->register(new DoctrineServiceProvider(), [
            'db.options' => [
                'driver' => 'pdo_sqlite',
                'path'   => $this->dbPath
            ]
        ]);

        $this['todosRepository'] = function () {
            return new TodosRepository($this['db']);
        };

        $this['todosController'] = function () {
            return new TodosController($this['twig'], $this['todosRepository']);
        };
    }

    private function initRoutes(): void
    {
        $this->get('/', function () {
            return $this['todosController']->index();
        });

        $this->get('/todos', function () {
            return $this->json($this['todosController']->fetch());
        });

        $this->post('/todos', function (Request $request) {
            $item = $request->request->all();
            return $this->json($this['todosController']->insert($item));
        });

        $this->put('/todos/{uuid}', function (Request $request, $uuid) {
            $item = $request->request->all();

            return $this->json($this['todosController']->update($uuid, $item));
        });

        $this->delete('/todos/{uuid}', function (Request $request, $uuid) {
            $item = $request->request->all();

            return $this->json($this['todosController']->delete($uuid));
        });
    }
}
