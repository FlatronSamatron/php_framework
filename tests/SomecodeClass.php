<?php

declare(strict_types=1);
namespace Tests;

class SomecodeClass
{
    public function __construct(private readonly CodeClass $codeClass)
    {
    }

    public function getCodeClass(): CodeClass
    {
        return $this->codeClass;
    }
}