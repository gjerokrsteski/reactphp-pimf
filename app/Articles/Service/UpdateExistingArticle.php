<?php
namespace Articles\Service;

use Articles\Model\Article;
use Pimf\EntityManager;
use Pimf\Param;
use Pimf\Route;
use Pimf\Util\Validator;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

final class UpdateExistingArticle
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
        $this->request->on('data', function ($requestBody) {

            $route = new Route('/articles/:id');

            if($route->init()->matches() === false){
                //method not allowed
                $this->response->writeHead(405);
                return $this->response->end();
            }

            $requestData = [];
            parse_str($requestBody, $requestData);
            $requestData = new Param($requestData + $route->getParams());

            $id = $requestData->get('id');
            $title = $requestData->get('title');
            $content = $requestData->get('content');

            $valid = new Validator($requestData);

            if (!$valid->digit('id') || !$valid->value('id', '>', 0)) {
                //bad request
                $this->response->writeHead(400);
                return $this->response->end();
            }

            if (!$title || !$content) {
                //bad request
                $this->response->writeHead(400);
                return $this->response->end();
            }

            $article = new Article($title, $content);
            $article = $this->entityManager->article->reflect($article, (int)$id);
            $updated = $this->entityManager->article->update($article);

            if ($updated === true) {
                $this->response->writeHead(200);

                return $this->response->end();
            }

            //not found
            $this->response->writeHead(404);
            return $this->response->end();
        });
    }
}