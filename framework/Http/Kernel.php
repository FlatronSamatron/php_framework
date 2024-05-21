<?php

declare(strict_types=1);
namespace Framework\Http;

use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector){
            $routes = include BASE_PATH . '/routes/wep.php';

            foreach ($routes as $route) {
                $collector->addRoute(...$route);
            }

//            $collector->get('/', function(){
//                $content = 'hi';
//                return new Response($content, 200, []);
//            });
//
//            $collector->get('/posts/{id}', function(array $vars){
//                $content = "post - {$vars['id']}";
//                return new Response($content, 200, []);
//            });


        });

        $routeInfo = $dispatcher->dispatch(
                $request->getMethod(),
                $request->getPath()
        );

        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);

    }
}