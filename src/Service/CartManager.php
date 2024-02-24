<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;

class CartManager
{

    public function __construct(

        private RequestStack $requestStack,
        private bool $emptyEnabled
    ) {}

    public function add(Product $product): bool
    {
        $session = $this->getSession();
        $cart = $this->getCartFromSession($session);

        $productId = $product->getId();

        if (!array_key_exists($productId, $cart)) {
            $cart[$productId] = ['product' => $product, 'quantity' => 1];
        } else {
            $cart[$productId]['quantity']++;
        }

        $this->updateCartInSession($session, $cart);
        return true;
    }

    public function remove(Product $product): bool
    {
        $session = $this->getSession();
        $cart = $this->getCartFromSession($session);

        $productId = $product->getId();

        if (array_key_exists($productId, $cart)) {
            unset($cart[$productId]);
            $this->updateCartInSession($session, $cart);
            return true;
        }

        return false;
    }

    public function empty(): bool
    {
        if (!$this->emptyEnabled) {
            return false;
        }

        $session = $this->getSession();
        $session->remove('cart');
        return true;
    }

    public function getCart(): array
    {
        $session = $this->getSession();
        return $this->getCartFromSession($session);
    }

    public function setQuantity(Product $product, int $newQuantity): bool
    {
        $session = $this->getSession();
        $cart = $this->getCartFromSession($session);
        $productId = $product->getId();

        if (!array_key_exists($productId, $cart)) {
            return false;
        }

        if ($newQuantity < 1) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = $newQuantity;
        }

        $this->updateCartInSession($session, $cart);
        return true;
    }

    public function getCartCount(): int
    {
        $cart = $this->getCart();
        $cartCount = 0;

        foreach ($cart as $cartItem) {
            $cartCount += $cartItem['quantity'];
        }

        return $cartCount;
    }

    public function getCartTotal(): float
{
    $cart = $this->getCart();
    $total = 0;

    foreach ($cart as $cartItem) {
        $product = $cartItem['product'];
        $quantity = $cartItem['quantity'];
        // utilisation d'un opérateur d'assignation abrégé 
        $total += $product->getPrice() * $quantity; 
    }

    //  On divise pour avoir le prix en euro 
    $totalInEuros = $total / 100;

    return $totalInEuros;
    }


    

    private function getSession()
    {
        return $this->requestStack->getCurrentRequest()->getSession();
    }

    private function getCartFromSession($session): array
    {
        return $session->get('cart', []);
    }

    private function updateCartInSession($session, $cart): void
    {
        $session->set('cart', $cart);
    }
}
