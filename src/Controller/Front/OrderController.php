<?php

namespace App\Controller\Front;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\LigneOrder;
use App\Service\StripeApi;
use App\Service\CartManager;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use function Symfony\Component\Clock\now;

#[Route('/commandes', name: 'front_order_')]
class OrderController extends AbstractController
{
    private $temporaryOrderData;

    public function __construct(

        private RequestStack $requestStack,
        private MailerInterface $mailer

    ) {
    }

    #[Route('/confirmation', name: 'confirm', methods: ['GET', 'POST'])]
    public function confirm(CartManager $cartManager, EntityManagerInterface $em): Response
    {
        $session = $this->getSession();
        $orderRef = uniqid();


        // Enregistrez la référence temporaire dans la session
        $session->set('temporary_order_ref', $orderRef);


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
        $order->setUser($this->getUser());
        $order->setRef($orderRef);
        $order->setCreatedAt(new \DateTimeImmutable());


        $session->set('temporary_order', [
            'order' => $order,
            'cart' => $cart,
        ]);

        $session->set('temporary_order_ref', $orderRef);

        return $this->render('front/order/confirm.html.twig', [
            'cart' => $cart,
            'orderRef' => $orderRef,

        ]);
    }

    #[Route('/process', name: 'payment', methods: ['GET', 'POST'])]
    public function process(
        CartManager $cartManager,
        EntityManagerInterface $em,
        Request $request,
        StripeApi $stripeApi,
    ): Response {

        $session = $this->getSession();
        $this->denyAccessUnlessGranted('ROLE_USER');
        $orderRef = $session->get('temporary_order_ref');
        $totalAmount = $cartManager->getCartTotal();

        // Stocker le montant total en session pour l'utiliser dans le formulaire
        $session->set('payment_amount', $totalAmount);

        // Récupérer la clé API de stripe ( .env)
        $stripePublicKey = $_ENV['STRIPE_PUBLIC_KEY'];

        $user = $this->getUser();
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order, [
            'user' => $user
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setCreatedAt(now());
            $order->setUser($user);
            $order->setRef($orderRef);
            //! ici j'ai fait en sorte de récupérer les données soumis dans le formulaire : 
            $address = $form->get("address")->getData();
            $addressComplement = $form->get("addressComplement")->getData();
            $zip = $form->get("zipCode")->getData();
            $city = $form->get('city')->getData();
            $phoneNumber = $form->get('phoneNumber')->getData();
            $billingAddress = $form->get('billingAddress')->getData();
            $billingAddressComplement = $form->get('billingAddressComplement')->getData();
            $billingZipCode = $form->get('billingZipCode')->getData();
            $billingCity = $form->get('billingCity')->getData();

            //! envoie en session 
            $session->set('temporary_order_data', [
                'address' => $address,
                'addressComplement' => $addressComplement,
                'zipCode' => $zip,
                'city' => $city,
                'phoneNumber' => $phoneNumber,
                'billingAddress' => $billingAddress,
                'billingAddressComplement' => $billingAddressComplement,
                'billingZipCode' => $billingZipCode,
                'billingCity' => $billingCity,
            ]);


            $em->persist($order);




            //! enlever flush 
            // $em->flush();

            // $this->addFlash(
            //     'success',
            //     '<strong>' . $user->getFirstname() . '</strong> .'
            // );
            // Redirigez vers la page de confirmation de paiement générique
            return $this->render('front/payment/payment.html.twig', [
                'orderRef'          => $orderRef,
                'totalAmount'       => $totalAmount,
                'stripePublicKey'   => $stripePublicKey,
                'order'             => $order,
                'form'              => $form,
                'user'              => $user
            ]);
        }


        // Redirigez vers la page de confirmation de paiement générique
        return $this->render('front/payment/paymentProcess.html.twig', [
            'orderRef'          => $orderRef,
            'totalAmount'       => $totalAmount,
            'stripePublicKey'   => $stripePublicKey,
            'order'             => $order,
            'form'              => $form,
            'user'              => $user
        ]);
    }


    #[Route('/payment/{orderRef}', name: 'payment_done', methods: ['GET', 'POST'])]
    public function payment(
        Request $request,
        $orderRef,
        CartManager $cartManager,
        StripeApi $stripeApi,
        EntityManagerInterface $em,
    ): Response {
        $user = $this->getUser();
        $session = $this->getSession();
        $temporaryOrder = $session->get('temporary_order');
        //! ici  je récupère ce que j'ai dans la session  pour en faire des variables utilisable rapidement : 
        $temporaryOrderData = $session->get('temporary_order_data');
        $address = $temporaryOrderData['address'];
        $zip    = $temporaryOrderData['zipCode'];
        $city    = $temporaryOrderData['city'];
        $addressComplement = $temporaryOrderData['addressComplement'];
        $phoneNumber = $temporaryOrderData['phoneNumber'];
        $billingAddress = $temporaryOrderData['billingAddress'];
        $billingAddressComplement = $temporaryOrderData['billingAddressComplement'];
        $billingZipCode = $temporaryOrderData['billingZipCode'];
        $billingCity = $temporaryOrderData['billingCity'];


        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$temporaryOrder || !isset($temporaryOrder['order'], $temporaryOrder['cart'], $temporaryOrderData)) {
            return $this->redirectToRoute('front_order_confirm');
        }

        $order = $temporaryOrder['order'];
        $totalAmount = $cartManager->getCartTotal();
        $token = $request->request->get('stripeToken');

        try {
            $paymentResult = $stripeApi->processPayment($totalAmount, $token);

            if ($paymentResult) {
                // Paiement réussi

                //!  Ici  j'ai utilisé les variables que j'ai récupérée de la session  ( et les autres champs)
                $order = new Order;
                $order->setUser($user);
                $order->setRef($orderRef);
                $order->setAddress($address);
                $order->setZipCode($zip);
                $order->setCity($city);
                $order->setAddressComplement($addressComplement);
                $order->setPhoneNumber($phoneNumber);
                $order->setBillingAddress($billingAddress);
                $order->setBillingAddressComplement($billingAddressComplement);
                $order->setBillingZipCode($billingZipCode);
                $order->setBillingCity($billingCity);



                $order->setCreatedAt(new \DateTimeImmutable());


                foreach ($temporaryOrder['cart'] as $cartItem) {
                    if (is_array($cartItem) && isset($cartItem['product'], $cartItem['quantity'])) {
                        $product = $cartItem['product'];
                        $quantity = $cartItem['quantity'];

                        $ligneOrder = new LigneOrder();
                        $ligneOrder->setOrder($order);
                        $ligneOrder->setName($product->getName());
                        $ligneOrder->setQuantity($quantity);
                        $ligneOrder->setPrice($product->getPrice());
                        $ligneOrder->setCreatedAt(new \DateTimeImmutable());

                        $em->persist($ligneOrder);
                    }
                }
                //! donc là c'est comme avant mais on perssist que mtn et on flush $order et $ligneorder : 
                $em->persist($order);
                $em->flush();

                //! Pour pas que ses données restent en session j'efface la clé  que j'ai créer pour récupérer les data du formulaire : 
                $session->remove('temporary_order_data');


                $ligneOrders = $em->getRepository(LigneOrder::class)->findBy(['order' => $order]);

                // Envoi de l'e-mail de confirmation
                $email = (new Email())
                    ->from('jonathanaulnette53@gmail.com')
                    ->to($order->getUser()->getEmail())
                    ->subject('Confirmation de commande')
                    ->html($this->renderView(
                        'email/confirmationCommande.html.twig',
                        ['user' => $user, 'order' => $order, 'ligneOrders' => $ligneOrders]
                    ));
                $this->mailer->send($email);

                $cartManager->empty();

                return $this->redirectToRoute('front_order_validate', ['orderRef' => $order->getRef()]);
            }

            $this->addFlash('error', 'Le paiement a été refusé. Veuillez réessayer.');
            return $this->redirectToRoute('front_order_confirm');
        } catch (\Stripe\Exception\CardException $e) {
            $this->addFlash('error', 'Erreur de carte : ' . $e->getMessage());
            return $this->redirectToRoute('front_order_confirm');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur s\'est produite : ' . $e->getMessage());
            return $this->redirectToRoute('front_order_confirm');
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
