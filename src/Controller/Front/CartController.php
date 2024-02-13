<?php

namespace App\Controller\Front;

use App\Entity\Product;
use App\Service\CartManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/panier', name: 'front_cart_')]

class CartController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CartManager $cartManager): Response
    {

        $cart = $cartManager->getCart();
        $total =$cartManager->getTotal();

        return $this->render('front/cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total
           
        ]);
    }
   #[Route('/ajouter/{id<\d+>}', name: 'add', methods: ['POST'])]
    public function addToCart(CartManager $cartManager, EntityManagerInterface $entityManager, $id): Response
    {
        // Vérification du produit à mettre dans le panier 
        $product = $entityManager->getRepository(Product::class)->find($id);

        if ($product === null) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        // Ajout du produit au panier
        $cartManager->add($product);

        // Retourner une réponse avec le message flash
        return new JsonResponse(['message' => 'Produit ajouté au panier.']);
    }

    #[Route('/supprimer/{id<\d+>}', name: 'remove', methods: ['POST'])]
    public function remove(CartManager $cartManager, EntityManagerInterface $entityManager, $id): Response
    {
         $product = $entityManager->getRepository(Product::class)->find($id);
        // Vérification du produit à supprimer du panier 
        if ($product === null) {
            throw $this->createNotFoundException("l'article  n'existe pas");
        }

        // on délègue toute la partie métier au service Cart Manager
        if ($cartManager->remove($product)) {
            $this->addFlash(
                'success',
                '<strong>' . $product->getName() . '</strong> a été supprimé de votre panier .'
            );
        }

        return new JsonResponse(['message' => 'Produit supprimé du panier.']);
    }

    #[Route('/vider', name: 'empty', methods: ['GET'])]
    public function empty(CartManager $cartManager): Response
    {
        if ($cartManager->empty()) {
            $this->addFlash(
                'success',
                ' Votre panier à été vidé '
            );
        } else {
            $this->addFlash(
                'danger',
                'Le panier ne peux pas être vidé '
            );
        }
        return $this->render('front/cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/{id<\d+>}', name: 'adjust_quantity', methods: ['POST'])]
    public function adjustQuantity(CartManager $cartManager, Product $product = null, Request $request): Response
    {
        // Vérification que le produit existe 
        if ($product === null) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        //Récupération de la nouvelle quantité 
        $newQuantity = (int) $request->request->get('new_quantity', 1);

        // on délègue toute la partie métier au service Cart Manager
        if ($cartManager->setQuantity($product, $newQuantity)) {
            $this->addFlash(
                'success',
                'La quantité de <strong>' . $product->getName() . '</strong> à été mis à jour .'
            );
        } else {
            $this->addFlash(
                'danger',
                'La quantité de <strong>' . $product->getName() . '</strong> dans votre panier ne peut pas être mis à jour.'
            );
        }

        return $this->redirectToRoute('front_cart_index');
    }
}
