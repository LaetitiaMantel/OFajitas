<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categorie', name: 'front_category_')]
class CategoryController extends AbstractController
{
    #[Route('/{slug}', name: 'show')]
    public function ProductsCategory(string $slug, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        // Récupère les categories correspondants au slug
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        // Récupère les produits correspondant au slug
        $products = $productRepository->findByCategory($slug);

        return $this->render('category/index.html.twig', [
            'products' => $products,
            'category' => $category,
    ]);
    }
}