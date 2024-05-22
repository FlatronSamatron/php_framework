<?php

declare(strict_types=1);
namespace Framework\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use Framework\Http\Exceptions\{MethodNotAllowedException, RouteNotFoundException};
use Framework\Http\Request;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch($request): array
    {
        [[$controller, $method], $vars] = $this->extractRouteInfo($request);

        return [[new $controller, $method], $vars];
    }

    private function extractRouteInfo(Request $request): array
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector){
            $routes = include BASE_PATH . '/routes/wep.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }

        });

        $routeInfo = $dispatcher->dispatch(
                $request->getMethod(),
                $request->getPath()
        );

        switch ($routeInfo[0]){
            case Dispatcher::FOUND:
                return [$routeInfo[1], $routeInfo[2]];
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = implode(',', $routeInfo[1]);
                throw new MethodNotAllowedException("Supported HTTP methods: {$allowedMethods}");
            default:
                throw new RouteNotFoundException("Route not found");
        }
    }
}