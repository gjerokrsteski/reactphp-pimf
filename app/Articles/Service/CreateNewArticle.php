<?php
namespace Articles\Service;

use Articles\Model\Article;
use Pimf\EntityManager;
use Pimf\Param;
use Pimf\Route;
use Pimf\Util\Json;
use Pimf\Util\Validator;
use React\Http\Response as ReactiveResponse;
use React\Http\Request as ReactiveRequest;

final class CreateNewArticle
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
        $this->request->on('data', function ($requestBody) {

            $route = new Route('/articles/:id');

            if($route->init()->matches() === true){
                //method not allowed
                $this->response->writeHead(405);
                return $this->response->end();
            }

            $requestData = [];
            parse_str($requestBody, $requestData);
            $requestData = new Param($requestData);

            $title = $requestData->get('title');
            $content = $requestData->get('content');

            if (!$title || !$content) {
                //bad request
                $this->response->writeHead(400);
                return $this->response->end();
            }

            $valid = new Validator($requestData);

            if ($valid->length('title', '<', 1) || $valid->length('content', '<', 1)) {
                //bad request
                $this->response->writeHead(400);
                return $this->response->end();
            }

            $newId = $this->em->article->insert(new Article($title, $content));

            if ($newId > 0) {
                $this->response->writeHead(201, ['Content-Type' => 'application/json; charset=utf-8']);

                return $this->response->end(Json::encode(compact('newId')));
            }

            //conflict
            $this->response->writeHead(409);
            return $this->response->end();

        });
    }
}