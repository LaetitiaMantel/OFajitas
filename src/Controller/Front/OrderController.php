<?php

namespace App\Controller\Front;

use App\Entity\LigneOrder;
use App\Entity\Order;
use App\Service\CartManager;
use App\Service\FakePaymentService; // Ajout du service fictif de paiement
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes', name: 'front_order_')]
class OrderController extends AbstractController
{
    #[Route('/valider', name: 'add', methods: ['GET', 'POST'])]
    public function add(CartManager $cartManager, EntityManagerInterface $em, FakePaymentService $fakePaymentService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->getUser()) {
            $this->addFlash('message', 'Vous devez être connecté pour valider une commande.');
            return $this->redirectToRoute('front_main_new');
        }

        $cart = $cartManager->getCart();

        if (empty($cart)) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('front_main_home');
        }

        $order = new Order();
        $order->setUser($this->getUser());
        $order->setRef(uniqid());
        $order->setCreatedAt(new \DateTimeImmutable());

        $em->persist($order);

        $totalAmount = 0;

        foreach ($cart as $cartItem) {
            $ligneOrder = new LigneOrder();
            $product = $cartItem['product'];
            $quantity = $cartItem['quantity'];

            $ligneOrder->setName($product->getName());
            $ligneOrder->setPrice($product->getPrice());
            $ligneOrder->setQuantity($quantity);
            $ligneOrder->setCreatedAt(new \DateTimeImmutable());

            $order->addLigneOrder($ligneOrder);

            $totalAmount += $product->getPrice() * $quantity;
        }

        // Flush uniquement la commande principale, les LigneOrder sont persistées automatiquement grâce à l'annotation "cascade" dans l'entité Order
        $em->flush();

        // Utilisez l'ID après l'appel à $em->flush()
        $paymentResult = $fakePaymentService->processPayment($order->getId(), $totalAmount);

        if ($paymentResult) {
            return $this->render('front/order/add.html.twig', [
                'cart' => $cart,
                'totalAmount' => $totalAmount,
                'paymentResult' => true,
            ]);
        } else {
            $this->addFlash('error', 'Le paiement a échoué. Veuillez réessayer.');
            return $this->redirectToRoute('front_main_home');
        }
    }
}
