<?php

declare(strict_types=1);
namespace App\Controllers;

use Framework\Http\Response;

class HomeController
{
    public function index(): Response
    {
        return new Response('hi');
    }
}