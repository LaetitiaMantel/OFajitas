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
