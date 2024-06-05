<?php

declare(strict_types=1);
namespace Framework\Controller;

use Framework\Http\Request;
use Framework\Http\Response;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;
    protected Request $request;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function render(string $view, array $arg = [], Response $response = null): Response
    {
        $content = $this->container->get('twig')->render($view, $arg);

        $response ??= new Response();

        $response->setContent($content);

        return $response;
    }

}