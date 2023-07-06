<?php

namespace App\Movie\Consumer;

use App\Movie\Enum\SearchTypeEnum;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbMovieConsumer
{
    public function __construct(
        private HttpClientInterface $omdbClient
    ) { }

    public function fetchMovie(SearchTypeEnum $type, string $value): array
    {
        $data = $this->omdbClient->request(
            'GET',
            '',
            ['query' =>[
                $type->value => $value,
                'plot' => 'full',
            ]]
        )->toArray();

        if (\array_key_exists('Error', $data) && $data['Error'] === 'Movie not found!') {
            throw new NotFoundHttpException('Movie not found!');
        }

        return $data;
    }
}