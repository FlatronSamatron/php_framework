<?php

declare(strict_types=1);
namespace Framework\Routing;

use Framework\Http\Request;
use League\Container\Container;

interface RouterInterface
{
    public function dispatch(Request $request, Container $container): array;

    public function registerRoutes(array $routes): void;
}