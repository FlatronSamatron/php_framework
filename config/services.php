<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Framework\Controller\AbstractController;
use Framework\Dbal\ConnectionFactory;
use Framework\Http\Kernel;

use League\Container\Argument\Literal\{ArrayArgument, StringArgument};
use Framework\Routing\{Router, RouterInterface};

use League\Container\ReflectionContainer;


use League\Container\Container;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH.'/.env');

//Application parameters
$routes      = include BASE_PATH.'/routes/wep.php';
$appEnv      = $_ENV['APP_ENV'] ?? 'local';
$viewsPath   = BASE_PATH.'/views';
$databaseUrl = 'pdo-mysql://root:root@db:3306?charset=utf8mb4';

//Application services
$container = new Container();
$container
        ->delegate(new ReflectionContainer(true));

$container->add('APP_ENV', new StringArgument($appEnv));
$container->add(RouterInterface::class, Router::class);

$container->extend(RouterInterface::class)
        ->addMethodCall('registerRoutes', [new ArrayArgument($routes)]);

$container->add(Kernel::class)
        ->addArgument(RouterInterface::class)
        ->addArgument($container);

$container->addShared('twig-loader', FilesystemLoader::class)
        ->addArgument(new StringArgument($viewsPath));

$container->addShared('twig', Environment::class)
        ->addArgument('twig-loader');

$container->inflector(AbstractController::class)
        ->invokeMethod('setContainer', [$container]);

$container->add(ConnectionFactory::class)
        ->addArgument(new StringArgument($databaseUrl));

$container->addShared(Connection::class, function () use ($container): Connection {
    return $container->get(ConnectionFactory::class)->create();
});

return $container;