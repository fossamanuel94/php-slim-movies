<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory; 


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

$app = AppFactory::create();
header('Access-Control-Allow-Origin: *');


//Include Movies
require __DIR__ . '/../routes/movies.php';

$app->run();