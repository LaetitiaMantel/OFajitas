<?php
namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;

class FavoriteManager
{
        public function __construct(
        private RequestStack $requestStack,
        
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
        // on récupère le favoris de la session
        $favoris = $session->get('favoris', []);

        // on rajoute le produit demandé
        // l'utilisation de array_key_exists garantit l'unicité des favoris
        if (!array_key_exists($product->getId(), $favoris)) {
            $favoris[$product->getId()] = [
                'product' => $product,
            ];
            $session->set('favoris', $favoris);
            return true;
        }else{
            return false;
        } 
    }

    public function remove(Product $product): bool
    {
        // on récupère la session
        $session = $this->requestStack->getCurrentRequest()->getSession();
        // on récupère les favoris  de la session
        $favoris = $session->get('favoris', []);

        // si l'entrée $product existe, on la supprime

        if (array_key_exists($product->getId(), $favoris)) {
            unset($favoris[$product->getId()]);
            $session->set('favoris', $favoris);
            return true;
        } else {
            return false;
        }
    }

    public function empty(): bool
    {
        // on récupère la session
        $session = $this->requestStack->getCurrentRequest()->getSession();
        // on supprime les favoris  stockés
        $session->remove('favoris');
        return true;
    }
}
