<?php
require_once 'vendor/autoload.php';
include_once 'app/bootstrap.app.php';

Pimf\Config::load($config);

$em =  new Pimf\EntityManager(
    Pimf\Pdo\Factory::get(Pimf\Config::get(Pimf\Config::get('environment') . '.db')),
    Pimf\Config::get('app.name')
);

try {

    $pdo = $em->getPDO();

    $res = $pdo->exec(
        file_get_contents(
            BASE_PATH . 'app/Articles/_database/create-table.sql'
        )
    ) or print_r($pdo->errorInfo(), true);

    echo $res === false
        ? 'PROBLEMS CREATING TABLE!'
        : 'TABLE SUCCESSFULLY RECREATED';

} catch (\PDOException $e) {
    throw new \RuntimeException($e->getMessage());
}
