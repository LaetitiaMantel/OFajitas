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
        return $this->render('front/cart/index.html.twig', ['cart' => $cartManager->getCart()]);
    }

    #[Route('/ajouter/{id<\d+>}', name: 'add', methods: ['POST'])]
    public function addToCart(CartManager $cartManager, EntityManagerInterface $entityManager, $id): JsonResponse
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if ($product === null) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        $cartManager->add($product);

        return new JsonResponse(['message' => 'Produit ajouté au panier.']);
    }

    #[Route('/supprimer/{id<\d+>}', name: 'remove', methods: ['POST'])]
    public function remove(CartManager $cartManager, EntityManagerInterface $entityManager, $id): JsonResponse
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if ($product === null) {
            throw $this->createNotFoundException("L'article n'existe pas");
        }

        if ($cartManager->remove($product)) {
            $this->addFlash('success', '<strong>' . $product->getName() . '</strong> a été supprimé de votre panier.');
        }

        return new JsonResponse(['message' => 'Produit supprimé du panier.']);
    }

    #[Route('/vider', name: 'empty', methods: ['GET'])]
    public function empty(CartManager $cartManager): Response
    {
        $message = $cartManager->empty() ? 'Votre panier a été vidé' : 'Le panier ne peut pas être vidé';

        $this->addFlash('success', $message);

        return $this->redirectToRoute('front_cart_index');
    }

    #[Route('/{id<\d+>}', name: 'adjust_quantity', methods: ['POST'])]
    public function adjustQuantity(CartManager $cartManager, Product $product = null, Request $request): Response
    {
        if ($product === null) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        $newQuantity = (int) $request->request->get('new_quantity', 1);

        if ($cartManager->setQuantity($product, $newQuantity)) {
            $this->addFlash('success', 'La quantité de <strong>' . $product->getName() . '</strong> a été mise à jour.');
        } else {
            $this->addFlash(
                'danger',
                'La quantité de <strong>' . $product->getName() . '</strong> dans votre panier ne peut pas être mise à jour.'
            );
        }

        return $this->redirectToRoute('front_cart_index');
    }

    #[Route('/count', name: 'get_cart_count', methods: ['POST'])]
    public function getCartCount(CartManager $cartManager): JsonResponse
    {
        return new JsonResponse(['cartCount' => $cartManager->getCartCount()]);
    }

     #[Route('/total', name: 'get_cart_total', methods: ['POST'])]
    public function getCartTotal(CartManager $cartManager): JsonResponse
    {
        return new JsonResponse(['cartTotal' => $cartManager->getCartTotal()]);
    }

}
