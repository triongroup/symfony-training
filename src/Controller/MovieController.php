<?php

namespace App\Controller;

use App\Form\MovieType;
use App\Movie\Consumer\OmdbMovieConsumer;
use App\Movie\Enum\SearchTypeEnum;
use App\Movie\Provider\MovieProvider;
use App\Movie\Transformers\OmdbMovieTransformer;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    public function decades(): Response
    {
        $decades = [1970, 1980, 2000];

        return $this->render('includes/_decades.html.twig', [
            'decades' => $decades
        ])->setMaxAge(3600);
    }

    #[Route('/omdb/{title}', name: 'app_movie_omdb')]
    public function omdb(string $title, OmdbMovieConsumer $consumer, OmdbMovieTransformer $movieTransformer, MovieProvider $movieProvider): Response
    {
        dd($movieProvider->getMovie(SearchTypeEnum::TITLE, $title));
        dd($consumer->fetchMovie(SearchTypeEnum::TITLE, $title));
        dd($movieTransformer->transform($consumer->fetchMovie(SearchTypeEnum::TITLE, $title)));

        return $this->render('movie/show.html.twig', [
            'movie' => []
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movie_edit', requirements: ['id' => '\d+'])]
    public function edit(int $id, Request $request, MovieRepository $repository): Response
    {
        $movie = $repository->find($id);
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($movie, true);

            return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
        }

        return $this->render('movie/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
