<?php
namespace Articles\Service;

use Pimf\Util\Json;
use React\Http\Response as ReactiveResponse;

final class ListApiUsageOptions
{
    /**
     * @var ReactiveResponse
     */
    protected $response;

    public function __construct(ReactiveResponse $response)
    {
        $this->response = $response;
    }

    public function __invoke()
    {
        $this->response->writeHead(200, ['Content-Type' => 'application/json; charset=utf-8']);

        return $this->response->end(Json::encode([
            'blog' => [
                'create new article' => [
                    'url'           => '/articles',
                    'method'        => 'POST',
                    'body params'        => [
                        'title'   => 'string',
                        'content' => 'string',
                    ],
                    'response body' => [
                        '{newId": integer}',
                    ],
                ],

                'retrieve specific article' => [
                    'url'           => '/articles/{id}',
                    'method'        => 'GET',
                    'url params'        => [
                        'id' => 'integer',
                    ],
                    'response body' => [
                        '{"id": "integer", "title": "string", "content": "string"}',
                    ],
                ],

                'update specific article' => [
                    'url'    => '/articles/{id}',
                    'method' => 'PUT',
                    'url params' => [
                        'id'      => 'integer',
                    ],
                    'body params' => [
                        'id'      => 'integer',
                        'title'   => 'string',
                        'content' => 'string',
                    ],
                ],

                'delete specific article' => [
                    'url'    => '/articles/{id}',
                    'method' => 'DELETE',
                    'url params' => [
                        'id' => 'integer',
                    ],
                ],
            ],
        ]));
    }
}