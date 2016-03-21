<?php
namespace Articles\Service;

use Pimf\EntityManager;
use Pimf\Param;
use Pimf\Route;
use Pimf\Util\Validator;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

final class DeleteExistingArticle
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

    public function __construct(EntityManager $em, ReactiveRequest $request, ReactiveResponse $response)
    {
        $this->em = $em;
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

        $deleted = $this->em->article->delete($id);

        if ($deleted === true) {
            $this->response->writeHead(200);
            return $this->response->end();
        }

        //not found
        $this->response->writeHead(404);
        return $this->response->end();
    }
}