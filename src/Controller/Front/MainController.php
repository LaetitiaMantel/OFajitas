<?php

namespace App\Controller\Front;


use App\Entity\ContactMessage;
use Doctrine\ORM\EntityManager;
use App\Form\ContactMessageType;
use Symfony\Component\Mime\Email;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\Clock\now;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'front_main_')]
class MainController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        // récupère les 12 derniers derniers produits de la bdd
        $newProducts = $productRepository->findBy([], ['createdAt' => 'DESC'], 8);
        $categoriesByOrder = $categoryRepository->findBy([], ['homeOrder' => 'ASC'], 3);

        return $this->render('front/main/index.html.twig', [
            'newProducts'   => $newProducts,
            'categoriesByOrder'   => $categoriesByOrder
        ]);
    }

    // route pour la barre de recherche
    #[Route('/search', name: 'search')]
    public function research(Request $request, ProductRepository $productRepository): Response
    {
        // on recupère les eventuels parametres rentrés dans la page d'acceuil
        $search = $request->query->get('search');
        // si il existe un parametre de recherche
        if ($search) {
            // alors on recupère les produits associés à la fonction "findByResearch"
            $products = $productRepository->findByResearch($search);
        }
        // on envoie le resultat au twig associé
        return $this->render('front/product/productList.html.twig', [
            'products' => $products,
        ]);
    }

    // route pour la page contact
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage->setCreatedAt(now());
            $entityManager->persist($contactMessage);
            $entityManager->flush();
            // Envoi de l'e-mail de confirmation
            $email = (new Email())
                ->from($contactMessage->getEmail())
                ->to('jonathanaulnette53@gmail.com')
                ->subject('Contact')
                ->html($this->renderView(
                    'email/contact.html.twig',
                    ['contactMessage' => $contactMessage]
                ));
            $this->mailer->send($email);
            $this->addFlash(
                'success',
                '<strong>' . $contactMessage->getName() . '</strong> votre message est bien envoyer.'
            );
            return $this->redirectToRoute('front_main_home', [], Response::HTTP_SEE_OTHER);
        }
        // on envoie le resultat au twig associé
        return $this->render('front/main/contact.html.twig', [
            'form' => $form->createView(),
        ]);
        }
    #[Route('/qui-sommes-nous', name: 'qsn')]
    public function qsn(): Response
    {
    // on envoie le resultat au twig associé
        return $this->render('front/main/qsn.html.twig', []);
    }
}
