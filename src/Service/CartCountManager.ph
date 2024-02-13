<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class CartCountManager
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
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
