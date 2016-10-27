<?php
namespace Articles\Application;

use Articles\Service\WriteAllowedRequestMethods;
use Pimf\EntityManager;
use Pimf\Route;
use Pimf\Uri;
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
    protected $em;

    /**
     * @var ReactiveRequest
     */
    protected $request;

    /**
     * @var ReactiveResponse
     */
    protected $response;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __invoke(ReactiveRequest $request, ReactiveResponse $response)
    {
        $this->request = $request;
        $this->response = $response;

        Uri::setup($this->request->getPath(), $this->request->getPath());

        $route = new Route('/articles(/:id)');

        // handle main route
        if($route->init()->matches() === false){
            $this->response->writeHead(500);
            return $this->response->end();
        }

        $routeTo = function($service){
          return $service();
        };

        // handle API requested resources
        switch ($this->request->getMethod()) {

            case 'GET':
                return $routeTo(new FindExistingArticle($this->em, $this->request, $this->response));

            case 'POST':
                return $routeTo(new CreateNewArticle($this->em, $this->request, $this->response));

            case 'PUT':
                return $routeTo(new UpdateExistingArticle($this->em, $this->request, $this->response));

            case 'DELETE':
                return $routeTo(new DeleteExistingArticle($this->em, $this->request, $this->response));

            case 'OPTIONS':
                return $routeTo(new ListApiUsageOptions($this->response));

            default:
                return $routeTo(new WriteAllowedRequestMethods($this->response));
        }

    }

}