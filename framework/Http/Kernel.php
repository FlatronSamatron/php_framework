<?php

declare(strict_types=1);
namespace Framework\Http;

use Doctrine\DBAL\Connection;
use Framework\Http\Exceptions\HttpException;
use Framework\Routing\RouterInterface;
use League\Container\Container;

class Kernel
{
    private string $appEnv;

    public function __construct(
            private RouterInterface $router,
            private Container $container
    ) {
        $this->appEnv = $container->get('APP_ENV');
    }

    public function handle(Request $request): Response
    {
        try {
            dd($this->container->get(Connection::class)->connect());
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routeHandler, $vars);
        } catch (\Exception $e) {
            dd($e);
            $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Exception $e): Response
    {
        if (in_array($this->appEnv, ['local', 'testing'])) {
            throw $e;
        }

        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response('Server Error', 500);
    }
}