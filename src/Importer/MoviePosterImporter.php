<?php

namespace App\Importer;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MoviePosterImporter
{
    public function __construct(
        private string $imdbUrl,
        private string $imdbApiKey,
        private EntityManagerInterface $entityManager,
        private HttpClientInterface $client,
        private LoggerInterface $logger
    ) {
    }

    public function import(Movie $movie): void
    {
        $movie->setPosterUrl($this->getImageUrl($movie->getTitle()));

        $this->entityManager->flush();
    }

    private function getImageUrl(string $title): ?string
    {
        $posterUrl = null;
        try {
            $response = $this->client->request(
                'GET',
                $this->imdbUrl . '/title/find?q=' . $title,
                [
                    'headers' => [
                        'x-rapidapi-host' => 'imdb8.p.rapidapi.com',
                        'x-rapidapi-key' => $this->imdbApiKey,
                    ],
                ]
            );
        } catch (\Exception $e) {
            $this->logger->error('TODO');

            return $posterUrl;
        }

        if (isset($response->toArray()['results'][0]['image']['url'])) {
            $posterUrl = $response->toArray()['results'][0]['image']['url'];
        }

        return $posterUrl;
    }
}