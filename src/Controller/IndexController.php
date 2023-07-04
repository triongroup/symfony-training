<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index_index')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findBy([], ['id' => 'DESC'], 6);

        return $this->render('index/index.html.twig', [
            'movies' => $movies,
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
