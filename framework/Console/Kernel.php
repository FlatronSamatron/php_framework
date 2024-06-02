<?php

declare(strict_types=1);
namespace Framework\Console;

class Kernel
{
    public function handle(): int
    {
        dd('Hello');

        return 0;
    }
}