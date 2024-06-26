<?php

declare(strict_types=1);
namespace Framework\Console;

use Psr\Container\ContainerInterface;

class Kernel
{
    public function __construct(
            private ContainerInterface $container,
            private Application $application
    ) {
    }

    public function handle(): int
    {
        $this->registerCommands();
        $status = $this->application->run();

        return $status;
    }

    private function registerCommands(): void
    {
        $namespace    = $this->container->get('framework-commands-namespace');
        $commandFiles = new \DirectoryIterator(__DIR__.'/Commands');

        foreach ($commandFiles as $commandFile) {
            if (!$commandFile->isFile()) {
                continue;
            }
            $command = $namespace.pathinfo($commandFile->getFilename(), PATHINFO_FILENAME);

            if (is_subclass_of($command, CommandInterface::class)) {
                $name = (new \ReflectionClass($command))->getProperty('name')->getDefaultValue();

                $this->container->add("console:$name", $command);
            }
        }
    }
}