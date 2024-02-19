<?php

namespace App\Controller\Front;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\LigneOrder;
use App\Service\CartManager;
use App\Service\FakePaymentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commandes', name: 'front_order_')]
class OrderController extends AbstractController
{
    public function __construct(

        private RequestStack $requestStack,

    ) {
    }

    #[Route('/confirmation', name: 'confirm', methods: ['GET', 'POST'])]
    public function confirm(CartManager $cartManager, EntityManagerInterface $em): Response
    {
        $session = $this->getSession();
        $temporaryOrderRef = uniqid();


        // Enregistrez la référence temporaire dans la session
        $session->set('temporary_order_ref', $temporaryOrderRef);


        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->getUser()) {
            $this->addFlash('message', 'Vous devez être connecté pour confirmer votre commande.');
            return $this->redirectToRoute('front_main_new');
        }

        $cart = $cartManager->getCart();


        if (empty($cart)) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('front_main_home');
        }

        $order = new Order();
        // $order->setUser($this->getUser());
        $order->setRef($temporaryOrderRef);
        $order->setCreatedAt(new \DateTimeImmutable());


        $session->set('temporary_order', [
            'order' => $order,
            'cart' => $cart,
        ]);

        $session->set('temporary_order_ref', $temporaryOrderRef);

        return $this->render('front/order/confirm.html.twig', [
            'cart' => $cart,
            'orderRef' => $temporaryOrderRef,

        ]);
    }

    #[Route('/process', name: 'payment', methods: ['GET'])]
    public function process(CartManager $cartManager): Response
    {
        $session = $this->getSession();
        $temporaryOrderRef = $session->get('temporary_order_ref');
        $totalAmount = $cartManager->getCartTotal();

        // Stockez le montant total en session pour l'utiliser dans le formulaire
        $session->set('payment_amount', $totalAmount);

        // Redirigez vers la page de confirmation de paiement générique
        return $this->render('front/payment/paymentProcess.html.twig', [
            'orderRef' => $temporaryOrderRef,
            'totalAmount' => $totalAmount,
        ]);
    }


    #[Route('/payment/{orderRef}', name: 'payment_done', methods: ['GET', 'POST'])]
    public function payment(Request $request, $orderRef, CartManager $cartManager, FakePaymentService $paymentService, EntityManagerInterface $em): Response
    {
        $session = $this->getSession();
        $temporaryOrder = $session->get('temporary_order');

        if (!$temporaryOrder || !isset($temporaryOrder['order'], $temporaryOrder['cart'])) {
            return $this->redirectToRoute('front_main_home');
        }

        $order = $temporaryOrder['order'];

        $orderRefEntity = $em->getRepository(Order::class)->findOneBy(['Ref' => $orderRef]);

        // Vérifiez si l'ordre récupéré correspond à l'ordre dans la session
        // if (!$order || $order->getId() !== $orderRefEntity->getId()) {
        //     throw $this->createNotFoundException('Order not found');
        // }

        // Récupérer le montant total directement depuis le panier
        //TODO: changer et récupérer via le formulaire ( changer aussi le formulaire pour récpérer via la cart )
        $totalAmount = $cartManager->getCartTotal();

        // Récupérer le numéro de carte depuis le formulaire
        $cardNumber = $request->request->get('card_number');

        // Processus de paiement simulé
        $paymentResult = $paymentService->processPayment($totalAmount, $cardNumber);

        if ($paymentResult) {
            // Paiement réussi
            $order = new Order();
            $order->setUser($this->getUser());
            $order->setRef($orderRef);
            $order->setCreatedAt(new \DateTimeImmutable());

            foreach ($temporaryOrder['cart'] as $cartItem) {
                if (is_array($cartItem) && isset($cartItem['product'], $cartItem['quantity'])) {
                    $product = $cartItem['product'];
                    $quantity = $cartItem['quantity'];
                    $ligneOrder = new LigneOrder();
                    $ligneOrder->setOrder($order);
                    $productName = $product->getName();                   
                    $ligneOrder->setName($productName);
                    $ligneOrder->setQuantity($quantity);
                    $ligneOrder->setPrice($product->getPrice());
                    $ligneOrder->setCreatedAt(new \DateTimeImmutable());

                    // Persistez chaque entité LigneOrder
                    $em->persist($ligneOrder);
                }
            }
            $em->persist($order);
            $em->flush();

            // Vider le panier après le paiement réussi
            $cartManager->empty();

            return $this->redirectToRoute('front_order_validate', ['orderRef' => $order->getRef()]);
        } else {
            // Paiement refusé
            $this->addFlash('error', 'Le paiement a été refusé. Veuillez réessayer.');

            return $this->redirectToRoute('front_cart_index');
        }
    }

    #[Route('/validate', name: 'validate', methods: ['GET'])]
    public function validate(): Response
    {
        $session = $this->getSession();
        $temporaryOrder = $session->get('temporary_order');

        if (!$temporaryOrder || !isset($temporaryOrder['order'])) {
            return $this->redirectToRoute('front_main_home');
        }

        $orderRef = $temporaryOrder['order']->getRef();

        return $this->render('front/order/validate.html.twig', [
            'orderRef' => $orderRef,
            'userName' => $this->getUser(),
        ]);
    }


    private function getSession()
    {
        return $this->requestStack->getCurrentRequest()->getSession();
    }
}
