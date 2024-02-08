<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class MainController extends AbstractController
{   

    #[Route('/', name: 'front_main_home')]
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

        // route pour la barre de recherche
        #[Route('/search', name: 'front_main_search')]
        public function research(Request $request, ProductRepository $productRepository) 
        {
            $search = $request->query->get('search');
            if ($search){
            $products = $productRepository->findByResearch($search);
            }
            return $this->render('search.html.twig', [
                'products' => $products,
            ]);
        }
}
