<?php

namespace App\Controller\Back;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/back/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'back_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('back/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'back_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setSlug($slugger->slug($product->getName()));
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $product->getName() . '</strong> a été ajouté à votre base.'
            );

            return $this->redirectToRoute('back_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('back/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'back_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setSlug($slugger->slug($product->getName()));
            $product->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $product->getName() . '</strong> a été modifié dans votre base.'
            );

            return $this->redirectToRoute('back_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $product->getName() . '</strong> a été supprimer de votre base.'
            );
        }

        return $this->redirectToRoute('back_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
