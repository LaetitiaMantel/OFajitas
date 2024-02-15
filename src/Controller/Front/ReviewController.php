<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    #[Route('/front/review', name: 'app_front_review')]
    public function index(): Response
    {
        return $this->render('front/review/index.html.twig', [
            'controller_name' => 'ReviewController',
        ]);
    }
}
