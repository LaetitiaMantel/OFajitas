<?php

namespace App\Controller\Back;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/back', name: 'back_main_')]
class MainController extends AbstractController
{   

        // route pour la barre de recherche
        #[Route('/search', name: 'search')]
        public function research(Request $request, ProductRepository $productRepository) : Response 
        {
            // on recupère les eventuels parametres rentrés dans la page d'acceuil
            $search = $request->query->get('search');
            // si il existe un parametre de recherche
            if ($search){
            // alors on recupère les produits associés à la fonction "findByResearch"
            $products = $productRepository->findByResearch($search);
            }
            // on envoie le resultat au twig associé
            return $this->render('back/product/index.html.twig', [
                'products' => $products,
            ]);
        }
}
