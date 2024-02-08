<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use App\Repository\CategoryRepository;

class CategoriesSubscriber implements EventSubscriberInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    // La méthode `onKernelController` est appelée à chaque fois qu'un contrôleur est sur le point d'être appelé
    // on récupérons toutes les catégories à partir du repository des catégories (`findAll()`) 
    // et nous les ajoutons aux attributs de la requête (`_categories`). 
    // Cela les rend disponibles dans les templates Twig associés à cette requête.
    public function onKernelController(ControllerEvent $event)
    {
        $categories = $this->categoryRepository->findAll();
        $event->getRequest()->attributes->set('_categories', $categories);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
