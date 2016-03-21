<?php
namespace Articles\Service;

use Pimf\EntityManager;
use Pimf\Param;
use Pimf\Route;
use Pimf\Util\Json;
use Pimf\Util\Validator;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

final class FindExistingArticle
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

    public function __invoke()
    {
        $route = new Route('/articles/:id');

        if($route->init()->matches() === false){
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $query = new Param($route->getParams());
        $id = $query->get('id');

        if (!$id) {
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $valid = new Validator($query);

        if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
            //bad request
            $this->response->writeHead(400);
            return $this->response->end();
        }

        $article = $this->em->article->find($id);

        if (!$article) {
            //not found
            $this->response->writeHead(404);
            return $this->response->end();
        }

        //yes we got the article finally!
        $this->response->writeHead(200, ['Content-Type' => 'application/json; charset=utf-8']);

        return $this->response->end(Json::encode($article->toArray()));
    }
}