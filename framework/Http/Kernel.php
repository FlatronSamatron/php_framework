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
            $collector->get('/', function(){
                $content = 'hi';
                return new Response($content, 200, []);
            });

            $collector->get('/posts/{id}', function(array $vars){
                $content = "post - {$vars['id']}";
                return new Response($content, 200, []);
            });
        });

        $routeInfo = $dispatcher->dispatch(
                $request->server['REQUEST_METHOD'],
                $request->server['REQUEST_URI']
        );

        [$status, $handler, $vars] = $routeInfo;

        return $handler($vars);

    }
}