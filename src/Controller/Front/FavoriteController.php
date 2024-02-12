<?php
namespace App\Controller\Front;

use App\Entity\Product;
use App\Service\FavoriteManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/favoris', name: 'front_favorite_')]
class FavoriteController extends AbstractController
{
    #[Route('/favoris', name: 'index')]
    
        public function index(FavoriteManager $favoriteManager): Response
        {
            $favoris = $favoriteManager->getFavoris();
            
            return $this->render('front/favoris/index.html.twig', [
                'favoris' => $favoris,
            ]);
        }

        #[Route('/ajouter/{id<\d+>}', name: 'add', methods: ['GET', 'POST'])]
        public function addToCart(FavoriteManager $favoriteManager, Product $product = null): Response
        {
            // Vérification du produit à mettre dans le panier 
            if ($product === null) {
                throw $this->createNotFoundException("Le produit demandé n'existe pas");
            }
    
            // on délègue toute la partie métier au service Cart Manager
            if ($favoriteManager->add($product)) {
                // Le produit n'était pas dans le panier, ajout avec succès
                $this->addFlash(
                    'success',
                    '<strong>' . $product->getName() . '</strong> a été ajouté à votre panier.'
                );
            } else {
                // Le produit était déjà dans le panier, augmentez la quantité
                $this->addFlash(
                    'info',
                    'La quantité de <strong>' . $product->getName() . '</strong> dans votre panier a été augmentée.'
                );
            }
            //TODO: enlever la redirection vers le panier 
            return $this->redirectToRoute('front_product_index');
        }
}
