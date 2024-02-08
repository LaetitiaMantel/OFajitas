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
