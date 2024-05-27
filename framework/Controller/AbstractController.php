<?php

declare(strict_types=1);
namespace Framework\Controller;

use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected ?ContainerInterface $container = null;
    
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

}