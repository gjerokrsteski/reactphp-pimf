<?php
namespace Articles\Application;

use Articles\Service\WriteAllowedRequestMethods;
use Pimf\EntityManager;
use Pimf\Route;
use Pimf\Uri;
use Pimf\Util\Json;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;
use Articles\Service\FindExistingArticle;
use Articles\Service\CreateNewArticle;
use Articles\Service\DeleteExistingArticle;
use Articles\Service\ListApiUsageOptions;
use Articles\Service\UpdateExistingArticle;

final class Listener
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ReactiveRequest
     */
    protected $request;

    /**
     * @var ReactiveResponse
     */
    protected $response;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ReactiveRequest $request, ReactiveResponse $response)
    {
        $this->request = $request;
        $this->response = $response;

        Uri::setup($this->request->getPath(), $this->request->getPath());

        $route = new Route('/articles(/:id)');

        // handle main route
        if ($route->init()->matches() === false) {
            $this->response->writeHead(406);
            return $this->response->end(
                Json::encode([
                    'list api usage options' => [
                        'url' => '/articles',
                        'method' => 'OPTIONS',
                    ],
                ]));
        }

        $routeTo = function ($service) {
            return $service();
        };

        // handle API requested resources
        switch ($this->request->getMethod()) {

            case 'GET':
                return $routeTo(new FindExistingArticle($this->entityManager, $this->request, $this->response));

            case 'POST':
                return $routeTo(new CreateNewArticle($this->entityManager, $this->request, $this->response));

            case 'PUT':
                return $routeTo(new UpdateExistingArticle($this->entityManager, $this->request, $this->response));

            case 'DELETE':
                return $routeTo(new DeleteExistingArticle($this->entityManager, $this->request, $this->response));

            case 'OPTIONS':
                return $routeTo(new ListApiUsageOptions($this->response));

            default:
                return $routeTo(new WriteAllowedRequestMethods($this->response));
        }

    }

}