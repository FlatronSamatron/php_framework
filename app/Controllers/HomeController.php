<?php

declare(strict_types=1);
namespace App\Controllers;

use Framework\Controller\AbstractController;
use Framework\Http\Response;

class HomeController extends AbstractController
{
    public function __construct()
    {
    }

    public function index(): Response
    {
        $content = "<h1>Hello {{name}}</h1>";

        return $this->render('home.html.twig', ['name' => 'HAHAH']);
    }
}