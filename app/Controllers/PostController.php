<?php

declare(strict_types=1);
namespace App\Controllers;

use App\Entities\Post;
use App\Services\PostService;
use Framework\Controller\AbstractController;
use Framework\Http\Response;

class PostController extends AbstractController
{
    public function __construct(private PostService $service)
    {
    }

    public function show(int $id): Response
    {
        $post = $this->service->findOrFail($id);

        return $this->render('posts.html.twig', ['post' => $post]);
    }

    public function create(): Response
    {
        return $this->render('create_post.html.twig');
    }

    public function store()
    {
        $post = Post::create(
                $this->request->postData['title'],
                $this->request->postData['body']
        );

        $post = $this->service->save($post);

        dd($post);
    }
}