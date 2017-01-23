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
    include('../views/story.php');
});

// Routes for controllers
$router->add('/directioncontroller', function() {
    include('../app/controller/direction.php');
});

$router->add('/inventorycontroller', function() {
    include('../app/controller/inventory.php');
});

// Routing for ajax files
$router->add('/directionajax', function() {
    include('../app/ajax/direction.js');
});

$router->add('/inventoryajax', function() {
    include('../app/ajax/inventory.js');
});

$router->getRoute($path);