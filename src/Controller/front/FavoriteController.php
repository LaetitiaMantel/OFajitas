<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FavoriteController extends AbstractController
{
    #[Route('/favoris', name: 'front_favorite_index')]
    
        public function index(): Response
        {
            return $this->render('favorites/index.html.twig', [
                'controller_name' => 'FavoritesController',
            ]);
        }
}
