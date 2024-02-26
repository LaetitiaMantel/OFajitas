<?php

namespace App\Controller\Front;

use App\Entity\Review;
use App\Entity\Product;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    #[Route('/produit/{slug}/critique', name: 'front_review_new')]
    public function new(EntityManagerInterface $entityManager, Product $product, Request $request, ReviewRepository $reviewRepository): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // association du produit courant avec la critique
            $review->setProduct($product);
            // on persiste et on sauvegarde
            $entityManager->persist($review);
            // on doit sauvegarder pour mettre en base la dernière critique
            // et l'utiliser lors du calcul du rating du produit
            $entityManager->flush();
            // on apelle une requête personnalisée qui calcule la moyenne
            $averageRating = $reviewRepository->averageRating($product);
            // on modifie le produit
            $product->setRating($averageRating);
            // on sauvegarde
            $entityManager->flush();
            $this->addFlash('success', 'La critique a été ajouté au produit.');
            $this->addFlash('success', 'La nouvelle note du produit est ' . (round($averageRating,2)));
            // on retourne sur la page de détail du produit
            return $this->redirectToRoute('front_product_show', ['slug' => $product->getSlug()]);
        }
        return $this->render('front/review/new.html.twig', [
            'product' => $product,
            'form'  => $form,
        ]);
    }
}
