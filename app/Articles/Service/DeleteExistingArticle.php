<?php
namespace Articles\Service;

use Articles\Contract\Invokable;
use Pimf\EntityManager;
use Pimf\Param;
use Pimf\Route;
use Pimf\Util\Validator;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

final class DeleteExistingArticle implements Invokable
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

    public function __construct(EntityManager $entityManager, ReactiveRequest $request, ReactiveResponse $response)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
        $this->response = $response;
    }

    public function __invoke($requestBody = '')
    {
        $route = new Route('/articles/:id');

        if($route->init()->matches() === false){
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $requestData = [];
        parse_str($requestBody, $requestData);
        $requestData = new Param($requestData + $route->getParams());

        $id = $requestData->get('id');

        if (!$id) {
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $valid = new Validator($requestData);

        if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $deleted = $this->entityManager->article->delete($id);

        if ($deleted === true) {
            $this->response->writeHead(200);
            return $this->response->end();
        }

        //not found
        $this->response->writeHead(404);
        return $this->response->end();
    }
}