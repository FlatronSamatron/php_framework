<?php

declare(strict_types=1);
namespace Framework\Http;

class Kernel
{

    public function __construct()
    {
    }

    public function handle(Request $request): Response
    {
        $content = 'hi';

        return new Response($content, 200, []);
    }
}