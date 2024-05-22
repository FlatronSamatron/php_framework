<?php

declare(strict_types=1);
namespace Framework\Routing;

use Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request): array;
}