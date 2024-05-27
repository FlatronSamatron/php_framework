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
        return new Response('hi');
    }
}