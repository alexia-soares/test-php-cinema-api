<?php

namespace App\Command;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:movie:import-image',
    description: 'Import movies poster',
)]
class MovieImportImageCommand extends Command
{
    public function __construct(
        private string $imdbUrl,
        private string $imdbApiKey,
        private EntityManagerInterface $entityManager,
        private HttpClientInterface $client,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $fails = $count = 0;

        /** @var Movie $movie */
        foreach ($this->entityManager->getRepository(Movie::class)->findBy(['posterUrl' => null]) as $movie) {
            try {
                $response = $this->client->request(
                    'GET',
                    $this->imdbUrl.'/title/find?q='.$movie->getTitle(),
                    [
                        'headers' => [
                            'x-rapidapi-host' => 'imdb8.p.rapidapi.com',
                            'x-rapidapi-key' => $this->imdbApiKey,
                        ],
                    ]
                );
            } catch (\Exception $e) {
                $io->error('Error : '.$e->getMessage());

                ++$fails;
                if ($fails > 5) {
                    $io->error('STOP : Two many trials.');

                    return Command::FAILURE;
                }

                continue;
            }

            if (200 !== $response->getStatusCode()) {
                $io->error('Error : '.$response->getContent());
            }

            if (isset($response->toArray()['results'][0]['image']['url'])) {
                $movie->setPosterUrl($response->toArray()['results'][0]['image']['url']);
            }

            if (50 === $count) {
                $count = 0;
                $this->entityManager->flush();
            }

            ++$count;
        }

        $this->entityManager->flush();

        $io->success('Success.');

        return Command::SUCCESS;
    }
}
