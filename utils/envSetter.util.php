<?php

require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Distribute the data using array key
$databases = [
    'pgHost' => $_ENV['PG_HOST'],
    'pgPort' => $_ENV['PG_PORT'],
    'pgUser' => $_ENV['PG_USER'],
    'pgPassword' => $_ENV['PG_PASSWORD'],
    'pgDB' => $_ENV['PG_DB'],
    'mongoHost' => $_ENV['MONGO_HOST'],
    'mongoPort' => $_ENV['MONGO_PORT'],
    'mongoUser' => $_ENV['MONGO_USER'],
    'mongoPassword' => $_ENV['MONGO_PASSWORD'],
    'mongoDB' => $_ENV['MONGO_DB'],
];
