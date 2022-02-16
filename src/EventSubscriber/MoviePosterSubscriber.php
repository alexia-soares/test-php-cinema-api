<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Movie;
use App\Importer\MoviePosterImporter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class MoviePosterSubscriber implements EventSubscriberInterface
{
    public function __construct(private MoviePosterImporter $moviePosterImporter)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['postWrite', EventPriorities::POST_WRITE],
        ];
    }

    public function postWrite(ViewEvent $event): void
    {
        $movie = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$movie instanceof Movie || Request::METHOD_POST !== $method) {
            return;
        }

        $this->moviePosterImporter->import($movie);
    }
}
