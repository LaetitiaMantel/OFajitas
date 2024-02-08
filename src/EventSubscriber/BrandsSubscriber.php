<?php

namespace App\EventSubscriber;

use App\Repository\BrandRepository;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class BrandsSubscriber implements EventSubscriberInterface
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    // La méthode `onKernelController` est appelée à chaque fois qu'un contrôleur est sur le point d'être appelé
    // on récupérons toutes les catégories à partir du repository des marques (`findAll()`) 
    // et nous les ajoutons aux attributs de la requête (`_brands`). 
    // Cela les rend disponibles dans les templates Twig associés à cette requête.
    public function onKernelController(ControllerEvent $event)
    {
        $brands = $this->brandRepository->findAll();
        $event->getRequest()->attributes->set('_brands', $brands);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
