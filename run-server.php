<?php
require_once 'vendor/autoload.php';
include_once 'app/bootstrap.app.php';

Pimf\Config::load($config);

$loop = React\EventLoop\Factory::create();

$dnsResolver = new \React\Dns\Resolver\Factory();
$dnsResolver->createCached(Pimf\Config::get('reactive.host'), $loop);

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

$socket->listen(Pimf\Config::get('reactive.port'), Pimf\Config::get('reactive.host'));

$loop->run();
