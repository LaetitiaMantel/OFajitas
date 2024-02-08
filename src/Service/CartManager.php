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
        // on récupère les favoris de la session
        $cart = $session->get('cart', []);
        // on rajoute le film demandé
        // l'utilisation de array_key_exists garanti l'unicité du favoris
        if (!array_key_exists($product->getId(), $cart)) {
            $cart[$product->getId()] = $product;
            $session->set('cart', $cart);
            return true;
        } else {
            return false;
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
    // Récupérez les données du panier depuis la session ou la base de données, selon votre implémentation
    // Dans cet exemple, je suppose que le panier est stocké dans la session
    $session = $this->requestStack->getCurrentRequest()->getSession();
    return $session->get('cart', []);
}
}
