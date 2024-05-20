<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use \Framework\Request;

$request = Request::createFromGlobals();

dd($request);

//router

//logic

//response