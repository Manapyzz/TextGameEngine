<?php

require_once('../vendor/autoload.php');
require_once('../helper/Router.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// create the request object
$request = Request::createFromGlobals();

$path = $request->getPathInfo();

$router = new Router();

$router->add('/', function() {
    include('../views/home.php');
});

$router->add('/story', function() {
    include('../views/helloworld.php');
});

$router->getRoute($path);