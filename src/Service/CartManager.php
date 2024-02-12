<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;

class CartManager
{
         public function __construct(
        private RequestStack $requestStack,
        private bool $emptyEnabled
    ) {
    }

    public function add(Product $product): bool
    {
      
        // on récupère la session
        $session = $this->requestStack->getCurrentRequest()->getSession();
        // on récupère le panier de la session
        $cart = $session->get('cart', []);
        $productId = $product->getId();
        // on rajoute le produit demandé
        // l'utilisation de array_key_exists garantit l'unicité du panier
        if (!array_key_exists($product->getId(), $cart)) {
            $cart[$product->getId()] = [
                'product' => $product,
                'quantity' => 1,
            ];
            $session->set('cart', $cart);
            return true;
        } else {
            // Si le produit est déjà dans le panier, augmentez la quantité
            $cart[$product->getId()]['quantity']++;
            $session->set('cart', $cart);
            return true;
        }
    }

public function remove(Product $product): bool
    {
        // on récupère la session
        $session = $this->requestStack->getCurrentRequest()->getSession();
        // on récupère le panier  de la session
        $cart = $session->get('cart', []);

        // si l'entrée $product existe, on la supprime

        if (array_key_exists($product->getId(), $cart)) {
            unset($cart[$product->getId()]);
            $session->set('cart', $cart);
            return true;
        } else {
            return false;
        }
    }

      public function empty(): bool
    {
        if (!$this->emptyEnabled) {
            return false;
        }
        // on récupère la session
        $session = $this->requestStack->getCurrentRequest()->getSession();
        // on supprime le panier  stockés
        $session->remove('cart');
        return true;
    }

    public function getCart(): array
{
    
    $session = $this->requestStack->getCurrentRequest()->getSession();
    return $session->get('cart', []);
}

    public function setQuantity(Product $product, int $newQuantity): bool
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $cart = $session->get('cart', []);

        // Si le produit n'est pas dans le panier, retourner false
        if (!array_key_exists($product->getId(), $cart)) {
            return false;
        }

        // Si la nouvelle quantité est inférieure à 1, supprimer le produit du panier
        if ($newQuantity < 1) {
            unset($cart[$product->getId()]);
        } else {
            // Mettre à jour la quantité du produit dans le panier
            $cart[$product->getId()]['quantity'] = $newQuantity;
        }

        // Sauvegarder le panier mis à jour dans la session
        $session->set('cart', $cart);

        return true;
    }

    public function getCartCount(): int
    {
        
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $cart = $session->get('cart', []);


        $cartCount = 0;

        foreach ($cart as $cartItem) {
            $cartCount += $cartItem['quantity'];
        }

        return $cartCount;
    }

  
}
