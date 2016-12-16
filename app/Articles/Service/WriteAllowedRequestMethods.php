<?php
namespace Articles\Service;

use Articles\Contract\Invokable;
use React\Http\Response as ReactiveResponse;

class WriteAllowedRequestMethods implements Invokable
{
    /**
     * @var ReactiveResponse
     */
    protected $response;

    public function __construct(ReactiveResponse $response)
    {
        $this->response = $response;
    }

    public function __invoke($requestBody = '')
    {
        $this->response->writeHead(405, [
            '405'                          => 'Method Not Allowed',
            'Access-Control-Allow-Methods' => 'POST, GET, PUT, DELETE',
        ]);

        return $this->response->end();
    }
    
}