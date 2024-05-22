<?php

declare(strict_types=1);
namespace App\Controllers;

use Framework\Http\Response;

class PostController
{
    public function show(int $id): Response
    {
        return new Response($id);
    }
}