<?php

namespace App\Controller ; 

use App\Entity\Product;
use App\Service\CartManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/panier', name: 'front_cart_')]

class CartController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCart();

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }
    #[Route('/ajouter/{id<\d+>}', name: 'add', methods: ['POST'])]
    public function add(CartManager $cartManager, Product $product = null, Request $request): Response
    {
        // Vérification du film à mettre en favoris
        if ($product === null) {
            throw $this->createNotFoundException("Le film demandé n'existe pas");
        }
        // on délègue toute la partie métier au service Cart Manager
        if ($cartManager->add($product)) {
            // on prépare un message flash
            // REFER : https://symfony.com/doc/current/session.html#flash-messages


            $this->addFlash(
                'success',
                '<strong>' . $product->getName() . '</strong> a été ajouté à votre liste de favoris.'
            );
        } else {
            $this->addFlash(
                'warning',
                '<strong>' . $product->getName() . '</strong> fait déjà partie de votre liste de favoris.'
            );
        }
        return $this->redirectToRoute('front_cart_index', []);
    }

    #[Route('/supprimer/{id<\d+>}', name: 'delete', methods: ['POST'])]
    public function remove(CartManager $cartManager, Product $product = null, Request $request): Response
    {
        // Vérification du produit à supprimer du panier 
        if ($product === null) {
            throw $this->createNotFoundException("Le film demandé n'existe pas");
        }

        // on délègue toute la partie métier au service Cart Manager
        if ($cartManager->remove($product)) {
            $this->addFlash(
                'success',
                '<strong>' . $product->getName() . '</strong> a été supprimé de votre liste de favoris.'
            );
        }

        return $this->render('cart/index.html.twig', []);
    }

    #[Route('/vider', name: 'empty', methods: ['GET'])]
    public function empty(CartManager $cartManager): Response
    {
        if ($cartManager->empty()) {
            $this->addFlash(
                'success',
                ' Votre liste de favoris a été vidée.'
            );
        } else {
            $this->addFlash(
                'danger',
                'La liste des favoris ne peut pas être vidée.'
            );
        }
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
