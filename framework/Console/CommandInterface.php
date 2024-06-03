<?php

declare(strict_types=1);
namespace Framework\Console;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}