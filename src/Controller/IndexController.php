<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/hello/{name}', name: 'app_index_hello', defaults: ['name' => 'World'])]
    public function hello(string $name): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => $name,
        ]);
    }
}
