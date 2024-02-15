<?php

namespace App\Controller\Front;

use App\Entity\LigneOrder;
use App\Entity\Order;
use App\Repository\ProductRepository;
use App\Service\CartManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes', name: 'front_order_')]
class OrderController extends AbstractController
{
    #[Route('/valider', name: 'add', methods: ['GET', 'POST'])]
    public function add(CartManager $cartManager, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->getUser()) {
            $this->addFlash('message', 'Vous devez être connecté pour valider une commande.');
            return $this->redirectToRoute('front_main_new');
        }

        // Récupérez le panier à partir du CartManager
        $cart = $cartManager->getCart();

        if (empty($cart)) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('front_main_home');
        }

        // Créez la commande
        $order = new Order();
        $order->setUser($this->getUser());
        $order->setRef(uniqid());
        $order->setCreatedAt(new \DateTimeImmutable());

        // Persistez la commande principale
        $em->persist($order);

        // Parcourez le panier pour créer les détails de commande
        foreach ($cart as $cartItem) {
            $ligneOrder = new LigneOrder();
            $product = $cartItem['product'];
            $quantity = $cartItem['quantity'];

            // Configurez les détails de commande
            $ligneOrder->setName($product->getName());
            $ligneOrder->setPrice($product->getPrice());
            $ligneOrder->setQuantity($quantity);
            $ligneOrder->setCreatedAt(new \DateTimeImmutable());

            // Ajoutez les détails de commande à la commande principale
            $order->addLigneOrder($ligneOrder);

            // Ne pas persister le produit ici, car il a déjà été persisté dans la base de données
            // Ne pas utiliser $em->persist($product);
        }

        // Flush uniquement la commande principale, les LigneOrder sont persistées automatiquement grâce à l'annotation "cascade" dans l'entité Order
        $em->flush();

        return $this->redirectToRoute('front_main_home'); // Redirigez après avoir validé la commande
    }
}
