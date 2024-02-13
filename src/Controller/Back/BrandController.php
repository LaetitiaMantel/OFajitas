<?php

namespace App\Controller\Back;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/back/brand')]
class BrandController extends AbstractController
{
    #[Route('/', name: 'back_brand_index', methods: ['GET'])]
    public function index(BrandRepository $brandRepository): Response
    {
        return $this->render('back/brand/index.html.twig', [
            'brands' => $brandRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'back_brand_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $brand = new Brand();
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brand->setSlug($slugger->slug($brand->getName()));
            $brand->setCreatedAt(new \DateTimeImmutable());
            $brand->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($brand);
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $brand->getName() . '</strong> a été ajouté à votre base.'
            );

            return $this->redirectToRoute('back_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/brand/new.html.twig', [
            'brand' => $brand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_brand_show', methods: ['GET'])]
    public function show(Brand $brand): Response
    {
        return $this->render('back/brand/show.html.twig', [
            'brand' => $brand,
        ]);
    }

    #[Route('/{id}/edit', name: 'back_brand_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Brand $brand, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $brand->setSlug($slugger->slug($brand->getName()));
            $brand->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $brand->getName() . '</strong> a été modifié dans votre base.'
            );

            return $this->redirectToRoute('back_brand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('back/brand/edit.html.twig', [
            'brand' => $brand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'back_brand_delete', methods: ['POST'])]
    public function delete(Request $request, Brand $brand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brand->getId(), $request->request->get('_token'))) {
            $entityManager->remove($brand);
            $entityManager->flush();
            $this->addFlash(
                'success',
                '<strong>' . $brand->getName() . '</strong> a été supprimer de votre base.'
            );
        }

        return $this->redirectToRoute('back_brand_index', [], Response::HTTP_SEE_OTHER);
    }
}
