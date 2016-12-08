<?php
require_once 'vendor/autoload.php';
include_once 'app/bootstrap.app.php';

Pimf\Config::load($config);

$loop = React\EventLoop\Factory::create();

$dnsResolver = new \React\Dns\Resolver\Factory();
$dnsResolver->createCached('127.0.0.1', $loop);

$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket);

$http->on('request',
    new Articles\Application\Listener(
        new Pimf\EntityManager(
            Pimf\Pdo\Factory::get(Pimf\Config::get(Pimf\Config::get('environment') . '.db')),
            Pimf\Config::get('app.name')
        )
    )
);

$socket->listen(Pimf\Config::get('reactive.port', 0), Pimf\Config::get('reactive.host', '0.0.0.0'));

echo 'Listening on host '.Pimf\Config::get('reactive.host', '0.0.0.0').' and port: ' . $socket->getPort() . PHP_EOL;

$loop->run();
