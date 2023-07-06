<?php

namespace App\Movie\Provider;

use App\Entity\Movie;
use App\Movie\Consumer\OmdbMovieConsumer;
use App\Movie\Enum\SearchTypeEnum;
use App\Movie\Transformers\OmdbMovieTransformer;
use App\Repository\MovieRepository;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovieProvider
{
    private ?SymfonyStyle $io = null;

    public function __construct(
        private MovieRepository $repository,
        private OmdbMovieConsumer $consumer,
        private OmdbMovieTransformer $transformer,
        private GenreProvider $genreProvider
    ) {}

    public function getMovie(SearchTypeEnum $type, string $value): Movie
    {
        $this->sendIo('text', 'Fetching informations from OMDb API');
        $data = $this->consumer->fetchMovie($type, $value);
        $this->sendIo('text', 'Movie found on OMDb API');

        if ($data['Response'] == 'False') {
            $this->sendIo('error', $data['Error']);
            throw new NotFoundHttpException($data['Error']);
        }

        if ($movie = $this->repository->findOneBy(['title' => $data['Title']])) {
            $this->sendIo('note', 'Movie already in database!');
            return $movie;
        }

        $movie = $this->transformer->transform($data);
        foreach ($this->genreProvider->getGenresFromString($data['Genre']) as $genre) {
            $movie->addGenre($genre);
        }

        $this->sendIo('text', 'Saving movie in database');
        $this->repository->save($movie, true);

        return $movie;
    }

    public function setIo(SymfonyStyle $io): void
    {
        $this->io = $io;
    }

    public function sendIo(string $type, string $message)
    {
        if ($this->io && method_exists($this->io, $type)) {
            $this->io->$type($message);
        }
    }
}