<?php

declare(strict_types=1);
namespace App\Controllers;

use Framework\Controller\AbstractController;
use Framework\Http\Response;

class PostController extends AbstractController
{
    public function show(int $id): Response
    {
        return $this->render('post.html.twig', ['id' => $id]);
    }

    public function create(): Response
    {
        return $this->render('create_post.html.twig');
    }
}