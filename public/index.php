<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Framework\Http\Request;
use Framework\Http\Response;

$request = Request::createFromGlobals();

$response = new Response('hi', 200, []);
$response->send();
//router

//logic

//response