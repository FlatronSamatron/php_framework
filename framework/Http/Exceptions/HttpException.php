<?php

declare(strict_types=1);
namespace Framework\Http\Exceptions;

class HttpException extends \Exception
{
    private int $statusCode = 400;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }
}