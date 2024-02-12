<?php
namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;

class FavoriteManager
{
        public function __construct(
        private RequestStack $requestStack,
        private bool $emptyEnabledFavoris,
    ) {
    }

    public function getFavoris(): array
    {

        $session = $this->requestStack->getCurrentRequest()->getSession();
        return $session->get('favoris', []);
    }

    public function add(Product $product): bool
    {
        // on récupère la session
        $session = $this->requestStack->getCurrentRequest()->getSession();
        // on récupère le panier de la session
        $favoris = $session->get('favoris', []);

        // on rajoute le produit demandé
        // l'utilisation de array_key_exists garantit l'unicité du panier
        if (!array_key_exists($product->getId(), $favoris)) {
            $favoris[$product->getId()] = [
                'product' => $product,
                'quantity' => 1,
            ];
            $session->set('favoris', $favoris);
            return true;
        } else {
            // Si le produit est déjà dans le panier, augmentez la quantité
            $favoris[$product->getId()]['quantity']++;
            $session->set('favoris', $favoris);
            return true;
        }
    }

  
}
