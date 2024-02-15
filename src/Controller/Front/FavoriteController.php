<?php
namespace App\Controller\Front;

use App\Entity\Product;
use App\Service\FavoriteManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/favoris', name: 'front_favorite_')]
class FavoriteController extends AbstractController
{

    #[Route('/', name: 'index')]
    
        public function index(FavoriteManager $favoriteManager): Response
        {
            $favoris = $favoriteManager->getFavoris();
            
            return $this->render('front/favoris/index.html.twig', [
                'favoris' => $favoris,
            ]);
        }

        #[Route('/ajouter/{id<\d+>}', name: 'add', methods: ['GET', 'POST'])]
        public function addToCart(FavoriteManager $favoriteManager, Product $product = null, Request $request): Response
        {
            // Vérification du produit à mettre dans les favoris
            if ($product === null) {
                throw $this->createNotFoundException("Le produit demandé n'existe pas");
            }
    
            // on délègue toute la partie métier au service favoris Manager
            if ($favoriteManager->add($product)) {
                // Le produit n'était pas dans les favoris, ajout avec succès
                $this->addFlash(
                    'success',
                    '<strong>' . $product->getName() . '</strong> a été ajouté à vos favoris.'
                );
            } else {
                // Le produit était déjà dans les favoris
                $this->addFlash(
                    'info',
                    $product->getName().' '.'est déjà en favoris'
                );
            }

            // Récupérer l'URL de la page précédente (avant l'ajout du produit aux favoris)
            $previousUrl = $request->headers->get('referer');

            // Rediriger vers l'URL de la page précédente
            return $this->redirect($previousUrl);
        }

        #[Route('/supprimer/{id<\d+>}', name: 'delete', methods: ['POST'])]
        public function remove(FavoriteManager $favoriteManager, Product $product = null, Request $request): Response
        {
            // Vérification du produit à supprimer 
            if ($product === null) {
                throw $this->createNotFoundException("l'article  n'existe pas");
            }
    
            // on délègue toute la partie métier au service Favorite Manager
            if ($favoriteManager->remove($product)) {
                $this->addFlash(
                    'success',
                    '<strong>' . $product->getName() . '</strong> a été supprimé de vos favoris .'
                );
            }
    
            
            // Récupérer l'URL de la page précédente (avant l'ajout du produit aux favoris)
            $previousUrl = $request->headers->get('referer');

            // Rediriger vers l'URL de la page précédente
            return $this->redirect($previousUrl);
    
        }

        #[Route('/vider', name: 'empty', methods: ['GET'])]
        public function empty(FavoriteManager $favoriteManager): Response
        {
            if ($favoriteManager->empty()) {
                $this->addFlash(
                    'success',
                    ' Vos favoris on été vidé '
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Les favoris ne peuvent pas être vidé '
                );
            }
            return $this->render('front/favoris/index.html.twig');
        }
}
