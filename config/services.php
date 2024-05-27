<?php

declare(strict_types=1);

use Framework\Http\Kernel;

use League\Container\Argument\Literal\{ArrayArgument, StringArgument};
use Framework\Routing\{Router, RouterInterface};

use League\Container\ReflectionContainer;


use League\Container\Container;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH.'/.env');

//Application parameters
$routes = include BASE_PATH.'/routes/wep.php';


//Application services
$container = new Container();

$container->delegate(new ReflectionContainer(true));

$appEnv = $_ENV['APP_ENV'] ?? 'local';

$container->add('APP_ENV', new StringArgument($appEnv));

$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
        ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
        ->addArgument(RouterInterface::class)
        ->addArgument($container);

return $container;