<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie', name: 'app_movie_index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/movie/{id}', name: 'app_movie_detail')]
    public function detail($id, MovieRepository $repository): Response
    {
//        $movie = [
//            'title' => 'Star Wars',
//            'releasedAt' => new \DateTimeImmutable('25-05-1977'),
//            'genre' => [
//                'Action',
//                'Adventure',
//                'Fantasy',
//            ],
//        ];

        $movie = $repository->find($id);

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
        ]);
    }
}
