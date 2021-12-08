<?php

require __DIR__ . '/../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager;
use Slim\Factory\AppFactory;
$db = new Manager();
$db->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'loginapp',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_hungarian_ci',
    'prefix' => '',
]);
$db->setAsGlobal();
$db->bootEloquent();


$app = AppFactory::create();
$routes = require '../src/routes.php';
$routes($app);
$app->run();