<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'front_main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $ProductRepository): Response
    {
        // récupère les 12 derniers derniers produits de la bdd
        $newProducts = $ProductRepository->findBy([], ['createdAt' => 'DESC'], 12);

        return $this->render('main/index.html.twig', [
            'newProducts'   => $newProducts,
         
        ]);
    }
}
