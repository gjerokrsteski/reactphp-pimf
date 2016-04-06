# Welcome to PHP Nuclear Reactor
This is an reactive RESTful API which uses ReactPHP and PIMF micro framework. 

ReactPHP is one of the most promising libraries. It brings the powerful concept of event-driven, non-blocking I/O 
(Hi NodeJS) to PHP. With this technology in mind we are able to write our own HTTP stack in PHP and have control back 
over the memory without destroying it at the end of each request. 

## Installation
- clone this repository
- Install a Composer to your project's root https://getcomposer.org
- run: composer install

## Run the awesome PHP Nuclear Reactor
- php run-server.php

## Try out the RESTful API
- http://{reactive.hosts}:{reactive.port}/articles/
- use HTTP method OPTIONS to find how to use the API


## Expected API behavior for resource: /articles
```
HTTP Verb |  Entire Collection (e.g. /articles)                                          | Specific Item (e.g. /articles/{id})
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
GET       | 400 (Bad Request)                                                            | 200 (OK), single article.
          |                                                                              | 404 (Not Found), if ID not found or invalid.
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
PUT       | 405 (Method Not Allowed)                                                     | 200 (OK),
          | - unless you want to update/replace every resource in the entire collection. | 404 (Not Found) if ID not found or 400 (Bad Request) if invalid.
          | - 'Location' header with link to API documentation                           |
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
POST      | 201 (Created),                                                               | 405 (Method Not Allowed)
          | - 'Location' header with link to /articles/{id} containing new ID.           | - 'Location' header with link to API documentation
-----------------------------------------------------------------------------------------------------------------------------------------------------------------
DELETE    | 404 (Not Found) or 405 (Method NOt Allowed)                                  | 200 (OK)
          | - unless you want to delete the whole collection—not often desirable.        | 404 (Not Found) if ID not found or 400 (Bad Request) if ID invalid.
          | - 'Location' header with link to API documentation                           |


```

## Benchmark Results
    
    [vagrant@gkrsteski php-reactor]$ loadtest http://10.0.49.227:5501/articles/10 -t 20 -c 20 --rps 1000
    [Wed Feb 10 2016 12:24:47 GMT+0100 (CET)] INFO Requests: 0, requests per second: 0, mean latency: 0 ms
    [Wed Feb 10 2016 12:24:52 GMT+0100 (CET)] INFO Requests: 4516, requests per second: 903, mean latency: 10 ms
    [Wed Feb 10 2016 12:24:57 GMT+0100 (CET)] INFO Requests: 9515, requests per second: 1000, mean latency: 0 ms
    [Wed Feb 10 2016 12:25:02 GMT+0100 (CET)] INFO Requests: 14515, requests per second: 1000, mean latency: 10 ms
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Target URL:          http://10.0.49.227:5501/articles/10
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Max time (s):        20
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Concurrency level:   20
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Agent:               none
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Requests per second: 1000
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Completed requests:  19512
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Total errors:        0
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Total time:          20.000516531000002 s
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Requests per second: 976
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Total time:          20.000516531000002 s
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO Percentage of the requests served within a certain time
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO   50%      2 ms
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO   90%      9 ms
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO   95%      18 ms
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO   99%      30 ms
    [Wed Feb 10 2016 12:25:07 GMT+0100 (CET)] INFO  100%      36 ms (longest request)

## Or run with Docker

Build a Docker image for your application by running:
    
    docker build -t="reactphp-pimf-api" .
    
Finally, run your application as a Docker container by running:

    docker run -d -P reactphp-pimf-api
    
    

## Run tests
Install a Composer to your project's root

    php composer.phar require "codeception/codeception:*"
    // or ...
    composer require "codeception/codeception:*"
    
Execute tests
    
    php vendor/codeception/codeception/codecept run
    // or if want to see steps ...
    php vendor/codeception/codeception/codecept run --steps
    // or if want to see fancy HTML report page
    php vendor/codeception/codeception/codecept run --html
