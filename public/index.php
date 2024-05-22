<?php

define("BASE_PATH", dirname(__DIR__));
require_once BASE_PATH.'/vendor/autoload.php';

use Framework\Http\{Kernel, Request};
use Framework\Routing\Router;

$request = Request::createFromGlobals();
$router = new Router();

$kernel = new Kernel($router);
$response = $kernel->handle($request);
$response->send();

//router

//logic

//response