<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'front_main_')]
class MainController extends AbstractController
{   

    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository,CategoryRepository $categoryRepository): Response
    {
        // récupère les 12 derniers derniers produits de la bdd
        $newProducts = $productRepository->findBy([], ['createdAt' => 'DESC'], 8);
        // récupère 3 catégories par ordre croissant choisit par le back office
        $categoriesByOrder = $categoryRepository->findBy([],['homeOrder' =>'ASC'], 3);
      
        return $this->render('main/index.html.twig', [
            'newProducts'   => $newProducts,
            'categoriesByOrder'   => $categoriesByOrder
        ]);
    }
}
