<?php

declare(strict_types=1);
namespace Framework\Http;

readonly class Request
{
    public function __construct(
            private array $getParams,
            private array $postData,
            private array $cookies,
            private array $files,
            private array $server,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getParam($key): string
    {
        return $this->getParams[$key];
    }
}