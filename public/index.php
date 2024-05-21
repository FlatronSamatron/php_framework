<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Framework\Http\{Kernel, Request};

$request = Request::createFromGlobals();

$kernel = new Kernel();
$response = $kernel->handle($request);
$response->send();

//router

//logic

//response