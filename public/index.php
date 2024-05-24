<?php

define("BASE_PATH", dirname(__DIR__));
require_once BASE_PATH.'/vendor/autoload.php';

use Framework\Http\{Kernel, Request};

$request   = Request::createFromGlobals();
$container = require BASE_PATH.'/config/services.php';

/**
 * @var \League\Container\Container $container
 */
$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);
$response->send();

//router

//logic

//response