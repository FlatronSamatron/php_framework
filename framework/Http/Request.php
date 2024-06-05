<?php

declare(strict_types=1);
namespace Framework\Http;

readonly class Request
{
    public function __construct(
            private array $getParams,
            public array $postData,
            private array $cookies,
            private array $files,
            private array $server,
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPath(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod()
    {
        return $this->server['REQUEST_METHOD'];
    }
}