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

        //  récupérer le total du panier après l'ajout
        $cartTotal = $cartManager->getCartTotal();

        return new JsonResponse([
            'message' => 'Produit ajouté au panier.',
            'cartTotal' => $cartTotal,
        ]);
    }

    #[Route('/supprimer/{id<\d+>}', name: 'remove', methods: ['POST'])]
    public function remove(CartManager $cartManager, EntityManagerInterface $entityManager, $id): JsonResponse
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if ($product === null) {
            throw $this->createNotFoundException("L'article n'existe pas");
        }

        if ($cartManager->remove($product)) {
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

    #[Route('/ajuster-quantite/{id<\d+>}', name: 'adjust_quantity_ajax', methods: ['POST'])]
    public function adjustQuantityAjax(CartManager $cartManager, Product $product = null, Request $request): JsonResponse
    {
        if ($product === null) {
            return new JsonResponse([
                'errorMessage' => "Le produit demandé n'existe pas"
            ], 404);
        }

        $newQuantity = (int) $request->request->get('new_quantity', 1);

        if ($cartManager->setQuantity($product, $newQuantity)) {
            $responseData = [
                'successMessage' => 'La quantité de <strong>' . $product->getName() . '</strong> a été mise à jour.',
                'quantity' => $newQuantity,
                'price' => $product->getPrice(),
            ];

            // Ajoutez le total du panier mis à jour
            $cartTotal = $cartManager->getCartTotal();
            $responseData['cartTotal'] = $cartTotal;

            // Ajoutez le total par produit mis à jour
            $productTotals = $cartManager->getProductTotals();
            $responseData['productTotals'] = $productTotals;

            return new JsonResponse($responseData);
        } else {
            return new JsonResponse([
                'errorMessage' => 'La quantité de <strong>' . $product->getName() . '</strong> dans votre panier ne peut pas être mise à jour.'
            ], 400);
        }
    }



    #[Route('/count', name: 'get_cart_count', methods: ['POST'])]
    public function getCartCount(CartManager $cartManager): JsonResponse
    {
        return new JsonResponse(['cartCount' => $cartManager->getCartCount()]);
    }

    #[Route('/total', name: 'get_total', methods: ['POST'])]
    public function getCartTotal(CartManager $cartManager): JsonResponse
    {
        return new JsonResponse(['cartTotal' => $cartManager->getCartTotal()]);
    }

    #[Route('/get_product_totals', name: 'get_product_totals', methods: ['GET'])]

    public function getProductTotalsAction( CartManager $cartManager): JsonResponse {
    $productTotals = $cartManager->getProductTotals();

    return $this->json($productTotals);
    }

}
