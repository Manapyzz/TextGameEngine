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
    include('../app/controller/places.php');
});

$router->add('/inventorycontroller', function() {
    include('../app/controller/inventory.php');
});

$router->add('/inventoryitemcontroller', function() {
    include('../app/controller/inventoryItem.php');
});

$router->add('/restartcontroller', function() {
    include('../app/controller/restart.php');
});

// Routing for ajax files
$router->add('/directionajax', function() {
    include('../app/ajax/direction.js');
});

$router->add('/inventoryajax', function() {
    include('../app/ajax/inventory.js');
});

$router->add('/inventoryitemajax', function() {
    include('../app/ajax/inventoryItem.js');
});

//Routing for assets
$router->add('/css', function() {
    include('../public/css/style.css');
    header("Content-type: text/css");
});

$router->add('/char', function() {
    include('../public/img/char.png');
});

$router->add('/char2', function() {
    include('../public/img/char2.png');
});

$router->add('/bg', function() {
    include('../public/img/bg.jpg');
});

$router->add('/up', function() {
    include('../public/img/up.png');
});

$router->add('/down', function() {
    include('../public/img/down.png');
});

$router->add('/right', function() {
    include('../public/img/right.png');
});

$router->add('/left', function() {
    include('../public/img/left.png');
});

$router->add('/inventory', function() {
    include('../public/img/inventory.png');
});


$router->getRoute($path);