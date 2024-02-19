<?php
namespace App\Controller\Front;


use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
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
        $categoriesByOrder = $categoryRepository->findBy([],['homeOrder' =>'ASC'], 3);
      
        return $this->render('front/main/index.html.twig', [
            'newProducts'   => $newProducts,
            'categoriesByOrder'   => $categoriesByOrder
        ]);
    }

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
            return $this->render('front/product/productList.html.twig', [
                'products' => $products,
            ]);
        }

      
        
   
}
