<?php

declare(strict_types=1);

use Framework\Http\Kernel;
use Framework\Routing\{Router, RouterInterface};

use League\Container\Container;

$container = new Container();

$container->add(RouterInterface::class, Router::class);
$container->add(Kernel::class)
        ->addArgument(RouterInterface::class);

return $container;