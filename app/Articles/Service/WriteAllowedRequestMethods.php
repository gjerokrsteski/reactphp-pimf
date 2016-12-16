<?php
namespace Articles\Service;

use React\Http\Response as ReactiveResponse;

class WriteAllowedRequestMethods
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